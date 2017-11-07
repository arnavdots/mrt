<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;

/**
 * Leads Controller
 *
 * @property \App\Model\Table\LeadsTable $Leads
 *
 * @method \App\Model\Entity\Lead[] paginate($object = null, array $settings = [])
 */
class LeadsController extends AppController {

    use MailerAwareTrait;

    public function initialize() {
        parent::initialize();
        $this->Installers = TableRegistry::get("Installers");
        $this->Transactions = TableRegistry::get("Transactions");
        $this->Billings = TableRegistry::get("Billings");
        $this->LeadsUsers = TableRegistry::get("LeadsUsers");
        $this->ConvertedLeads = TableRegistry::get("ConvertedLeads");
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {

        $query = $this->Leads->find();
        $conditions = [];

        if (isset($this->request->query['status']) && $this->request->query['status'] != "") {
            $conditions[] = ['Leads.status' => $this->request->query['status']];
        }

        if (isset($this->request->query['property_type']) && $this->request->query['property_type'] != "") {
            $conditions[] = ['Leads.property_type' => $this->request->query['property_type']];
        }

        if (isset($this->request->query['roof_type']) && $this->request->query['roof_type'] != "") {
            $conditions[] = ['Leads.roof_type' => $this->request->query['roof_type']];
        }

        if (isset($this->request->query['is_converted']) && $this->request->query['is_converted'] != "") {
            $conditions[] = ['Leads.is_converted' => $this->request->query['is_converted']];
        }

        if (isset($this->request->query['state']) && $this->request->query['state'] != "") {
            $conditions[] = ['Leads.state' => $this->request->query['state']];
        }

        if (isset($this->request->query['system_type']) && $this->request->query['system_type'] != "") {
            $conditions[] = ['Leads.system_type' => $this->request->query['system_type']];
        }



        if (!empty($this->request->query)) {
            $this->request->data = $this->request->query;
        }

        $query->where($conditions);
        $options['order'] = ['Leads.id' => 'DESC'];
        $options['limit'] = $this->ConfigSettings['admin_page_limit'];

        $this->paginate = $options;
        $leads = $this->paginate($query);
        $dateformat = Configure::read('Setting.admin_date_format');

        $this->set(compact("leads", "dateformat"));
        $this->set('_serialize', ['leads']);
    }

    /**
     * View method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {

        $lead = $this->Leads->get($id, [
            'contain' => ['LeadsUsers' => function($q) {
                    return $q->contain(['Installers']);
                }]
        ]);
        $dateformat = Configure::read('Setting.admin_date_time_format');
        $this->set(compact('lead', 'dateformat'));
        $this->set('_serialize', ['lead']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Lead id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null) {
        // $matching is use for check 'lead_matching' method will run or not 
        $matching = 0;
        $lead = $this->Leads->get($id, [
            'contain' => ['LeadsUsers' => function($q) {
                    return $q->contain(['Installers', 'Installers.InstallerCompanyDetail']);
                }]
        ]);

        // $old_status store old status of lead before save
        $old_status = $lead->status;

        if ($this->request->is(['patch', 'post', 'put'])) {

            // lead status change from pending to vetted
            if ($old_status == 0 && $this->request->data['status'] == 1) {
                $matching = 1;
                $this->request->data['status'] = 5;
            }

            // get all leads_users(installers)
            if (!empty($this->request->data['leads_users'])) {
                foreach ($this->request->data['leads_users'] as $key => $lead_userdata) {
                    if (empty($lead_userdata['user_id'])) {
                        unset($this->request->data['leads_users'][$key]);
                    } else {
                        $installer_status = $this->Installers->InstallerSetting->find()->where(['InstallerSetting.user_id' => $lead_userdata['user_id']])->select(['automation'])->first();
                        $this->request->data['leads_users'][$key]['status'] = $installer_status->automation;

                        if ($installer_status->automation == 0) {
                            $this->request->data['leads_users'][$key]['accepted_date'] = date('Y-m-d');
                        }
                        // Lead assignment email to installers

                        $installersdata = $this->Installers->get($lead_userdata['user_id'], [
                            'contain' => []
                        ]);

                        $installer_name = $installersdata->first_name . ' ' . $installersdata->last_name;
                        $installer_email = $installersdata->email;
                        $this->getMailer('Manu')->send('lead_assignment_installer', [$lead->id, $installer_name, $installer_email]);
                    }
                }
            }
            $latlong = $this->getLatLng($this->request->data['street_name'], $this->request->data['suburb'], $this->request->data['postcode'], $this->request->data['state']);
            if (!empty($latlong)) {
                $this->request->data['latitude'] = $latlong['lat'];
                $this->request->data['longitude'] = $latlong['lng'];
            } else {
                $this->request->data['latitude'] = null;
                $this->request->data['longitude'] = null;
            }
            $lead = $this->Leads->patchEntity($lead, $this->request->getData());
            if ($this->Leads->save($lead)) {
                // Insert installer in Transaction table
                if (!empty($this->request->data['leads_users'])) {
                    $this->installerTransactions($lead->id, $this->request->data['leads_users']);
                }

                if ($matching == 1) {
                    $this->leads_matching($lead);
                }
                if ($this->request->data['status'] == 2 && $old_status == 5) {

                    // Get all installer list
                    $installerInfo = [];
                    if (!empty($lead->leads_users)) {
                        foreach ($lead->leads_users as $key => $installers_info) {
                            $installerInfo[$key]['company_name'] = $installers_info->installer->installer_company_detail->company_name;
                            $installerInfo[$key]['website_url'] = $installers_info->installer->installer_company_detail->website_url;
                        }
                    }
                    // sending "lead close" email.
                    $customer_name = $lead->first_name . ' ' . $lead->surname;
                    $this->getMailer('Manu')->send('lead_closed', [$customer_name, $lead->email, $lead->platform_key, $installerInfo]);
                }

                $this->Flash->success(__('The lead has been saved.'));
                return $this->redirect(['action' => 'edit', $id]);
            } else {
                $this->Flash->error(__('The lead could not be saved. Please, try again.'));
            }
        }
        $installers = array();
        //$conn = ConnectionManager::get('default');
        // if (!empty($lead->latitude) && !empty($lead->longitude)) {
        // $installers = $conn->execute("CALL `solarpanel`.`lead_matching`(" . $lead->latitude . "," . $lead->longitude . "," . $lead->system_type . "," . $lead->state . ")")->fetchAll('assoc');
        //}
        //if (empty($installers)) {
        $installer_model = $this->loadModel("Installers");
        $installers = $installer_model->find()->select(['user_id' => 'id', 'first_name', 'last_name'])->where(['status' => 1, 'role_id' => 2])->hydrate(false)->toArray();
        // }
        $this->set(compact('lead', 'installers'));
        $this->set('_serialize', ['lead']);
    }

    /*
     * Delete Method
     */

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $lead = $this->Leads->get($id);
        if ($this->Leads->delete($lead)) {
            $this->Flash->success(__('The lead has been deleted.'));
        } else {
            $this->Flash->error(__('The lead could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /*
     * leads_matching Method
     * leads_matching use for leads assignment to the installers
     * 
     */

    public function leads_matching($lead) {

        // $count stored "max number of inatallers" to be assign in lead
        $count = Configure::read('max_number_of_installers');

        // Call stored procedure method
        $conn = ConnectionManager::get('default');
        $result = array();
        if (!empty($lead->latitude) && !empty($lead->longitude)) {
            $is_off = 0;
            if ($lead->system_type == 4) {
                $is_off = 1;
            }
            $result = $conn->execute("CALL `solarpanel`.`lead_matching`(" . $lead->latitude . "," . $lead->longitude . "," . $lead->system_type . "," . $lead->state . "," . $is_off . ")")->fetchAll('assoc');
            //   $result = $conn->execute("CALL `solarpanel`.`lead_matching_1`(" . $lead->latitude . "," . $lead->longitude . "," . $lead->system_type . "," . $lead->state . ")")->fetchAll('assoc');
            //    echo "CALL `solarpanel`.`lead_matching_1`(" . $lead->latitude . "," . $lead->longitude . "," . $lead->system_type . "," . $lead->state . ")";
        }
        if (!empty($result)) {
            if (sizeof($result) > 3) {

                // 1. Eliminate installers that have surpassed their maximum lead quantity for the month

                $quantity_filter = $this->leads_filter($result, 'quantity_filter');

                if (sizeof($quantity_filter) > 3) {

                    // 2. Preference will be given to installers that are 'upfront' billing method

                    $billing_filter = $this->leads_filter($quantity_filter, 'billing_method', 1);

                    if (sizeof($billing_filter) > 3) {

                        // 3. Installers that have ‘Send me leads as they come in’ ticked in account settings will get first preference on the lead

                        $automation_filter = $this->leads_filter($billing_filter, 'automation', 0);

                        if (sizeof($automation_filter) > 3) {

                            // 4. Installer will get preference first which have higher 'Administrator's rating'

                            $distributor_rating_filter = $this->leads_filter($automation_filter, 'distributor_rating');
                            $this->insert_filter($lead->id, $distributor_rating_filter);
                        } else {
                            $final_filter = $this->final_filter($automation_filter, $billing_filter);
                            $this->insert_filter($lead->id, $final_filter);
                        }
                    } else {
                        $final_filter = $this->final_filter($billing_filter, $quantity_filter);
                        $this->insert_filter($lead->id, $final_filter);
                    }
                } else {
                    $final_filter = $this->final_filter($quantity_filter, $result);
                    $this->insert_filter($lead->id, $final_filter);
                }
            } else {
                $final_filter = $this->final_filter($result);
                $this->insert_filter($lead->id, $final_filter);
            }
        } else {
            $this->getMailer('Manu')->send('lead_assignment', [$lead->id]);
        }
    }

    /*
     * leads_filter use for filter leads with different different conditions
     * $field_name = name of field in db
     * $field_value = value for where conditions
     */

    public function leads_filter($result, $field_name, $field_value = null) {

        // Quantity Filter

        if ($field_name == 'quantity_filter') {
            foreach ($result as $installer_data) {
                $installersids[] = $installer_data['user_id'];
                $installersids[$installer_data['user_id']] = $installer_data['lead_quantity'];
            }
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
            $findInstallers_q = $this->Installers->find();
            $findInstallers_q->select(['LeadsUsers.user_id', 'count' => $findInstallers_q->func()->count('*')]);
            $installers_data = $findInstallers_q
                    ->matching('LeadsUsers', function(\Cake\ORM\Query $q) use($installersids, $start_date, $end_date) {
                                $q
                                ->where(['LeadsUsers.user_id IN' => $installersids])
                                ->where(['DATE(LeadsUsers.created) >= ' => $start_date])
                                ->where(['DATE(LeadsUsers.created) <= ' => $end_date]);

                                return $q;
                            })
                    ->group('LeadsUsers.user_id')
                    ->hydrate(false)
                    ->toArray();

            $toberemove = array();
            foreach ($installers_data as $installers_data_val) {

                $user_count = $installers_data_val['count'];
                $userid = $installers_data_val['_matchingData']['LeadsUsers']['user_id'];

                // Check installer "max lead quantity" is small then "alraedy assigned leads" count
                if ($installersids[$userid] <= $user_count) {
                    $toberemove[] = $userid;
                }
            }

            foreach ($result as $index => $installers_data) {

                if (in_array($installers_data['user_id'], $toberemove)) {
                    unset($result[$index]);
                }
            }
            $result = array_filter($result);
            return $result;
        } else if ($field_name == 'distributor_rating') {    // Adminstrator rating  Filter
            $distributor_rating_arr = array();
            foreach ($result as $key => $row) {
                $distributor_rating_arr[$key] = $row['distributor_rating'];
                $distance_rating_arr[$key] = $row['distance'];
            }
            array_multisort($distributor_rating_arr, SORT_DESC, $distance_rating_arr, SORT_ASC, $result);

            return $result;
        } else {
            foreach ($result as $key => $result_data) {


                if ($result_data[$field_name] == $field_value) {
                    $filter_users[] = $result_data;
                }
            }
            return $filter_users;
        }
    }

    /*
     * final_filter use for fetch only 3 installers
     * This method call when number of installers is less then 'max_number_of_installers'(3) then we will go one up level filter data and fetch remaning installers.
     * $result store just up one filter data 
     * $filter_result store current filtered data
     */

    public function final_filter($filter_result, $result = null) {
        if (sizeof($filter_result) < Configure::read('max_number_of_installers')) {
            $remaning_installers = Configure::read('max_number_of_installers') - sizeof($filter_result);

            foreach ($filter_result as $filter_result_data) {
                $users[] = $filter_result_data['user_id'];
            }
            if (!empty($result)) {
                foreach ($result as $index => $result_data) {

                    if (in_array($result_data['user_id'], $users)) {
                        unset($result[$index]);
                    }
                }
                $result = array_filter($result);
                $result = array_slice($result, 0, $remaning_installers);
                $filter_result = array_merge($result, $filter_result);
            }
        }
        return $filter_result;
    }

    /*
     * insert_filter use for insert matching leads and user data in "LeadsUsers" table
     * An email will send to admin
     */

    function insert_filter($lead_id, $final_result = null) {
        $i = 0;
        $data = array();
        $is_any_user_pending = 0;
        if (!empty($final_result)) {
            $result = array_slice($final_result, 0, Configure::read('max_number_of_installers'));
            foreach ($result as $result_data) {
                $data['leads_users'][$i]['user_id'] = $result_data['user_id'];
                $data['leads_users'][$i]['lead_id'] = $lead_id;
                $data['leads_users'][$i]['status'] = $result_data['automation'];
                if ($result_data['automation'] == 1) {
                    $is_any_user_pending = 1;
                } else {
                    $data['leads_users'][$i]['accepted_date'] = date('Y-m-d');
                }
                $i++;
            }
        }
        if (sizeof($final_result) < 3 || empty($final_result)) {
            $data['assignment_status'] = 1;
        }
        $leadsUser = $this->Leads->get($lead_id);

        // If installers are less then 3 then leads status should be "Open"
        if (sizeof($result) < 3 || $is_any_user_pending == 1) {
            $leadsUser->status = 5;
        } else {   // Lead status should be "closed"
            $leadsUser->status = 2;
        }
        $leadsUser = $this->Leads->patchEntity($leadsUser, $data);
        if ($this->Leads->save($leadsUser)) {


            // Insert installer in Transaction table
            $this->installerTransactions($lead_id, $result);
            $installerInfo = [];
            if (sizeof($result) > 0) {
                $lead = $this->Leads->get($lead_id, ['contain' => ['LeadsUsers', 'LeadsUsers.Installers', 'LeadsUsers.Installers.InstallerCompanyDetail']]);

                if (!empty($lead->leads_users)) {
                    foreach ($lead->leads_users as $key => $installers_info) {
                        $installerInfo[$key]['company_name'] = $installers_info->installer->installer_company_detail->company_name;
                        $installerInfo[$key]['website_url'] = $installers_info->installer->installer_company_detail->website_url;
                        // Lead assignment email to installers
                        $installer_name = $installers_info->installer->first_name . ' ' . $installers_info->installer->last_name;
                        $installer_email = $installers_info->installer->email;
                        $this->getMailer('Manu')->send('lead_assignment_installer', [$lead_id, $installer_name, $installer_email]);
                    }
                }
            }
            if (sizeof($result) < 3 || $is_any_user_pending == 1) {
                $this->getMailer('Manu')->send('lead_assignment', [$lead_id, $installerInfo]);
            } else {

                // sending "lead close" email.
                $customer_name = $lead->first_name . ' ' . $lead->surname;
                $this->getMailer('Manu')->send('lead_closed', [$customer_name, $leadsUser->email, $leadsUser->platform_key, $installerInfo]);
            }
        }
    }

    /*
     * Billing cronJob
     * Fetch data from transaction table abd insert into billing table by month and year wise.
     */

    public function billingGenerate() {

        $current_day = date('d');

        if ($current_day == Configure::read('InvoiceDate')) {

            $last_month_year = date('F, Y', strtotime("-1 month"));
            $invoice_date = date('Y-m-t H:i:s', strtotime("-1 month"));
            $query = $this->Transactions->find('all', array(
                        'conditions' => array('DATE_FORMAT(Transactions.created,"%Y-%m") = "' . date('Y-m', strtotime("-1 month")) . '"')
                    ))->contain(['Installers', 'Installers.BillingAddress']);

            $transactions = $query->toArray();



            if (!empty($transactions)) {

                // Sum of amount according user_id
                foreach ($transactions as $transactions_data) {
                    if (!empty($billing_arr) && key_exists($transactions_data['user_id'], $billing_arr)) {
                        $billing_arr[$transactions_data['user_id']] += $transactions_data['amount'];
                    } else {
                        $billing_arr[$transactions_data['user_id']] = $transactions_data['amount'];
                    }
                    $installer_info[$transactions_data['user_id']]['name'] = $transactions_data['installer']->billing_addres->first_name . ' ' . $transactions_data['installer']->billing_addres->surname;
                    $installer_info[$transactions_data['user_id']]['email'] = $transactions_data['installer']->billing_addres->email;
                    if (!empty($transactions_data['installer']->billing_addres->cc_emails)) {
                        $installer_info[$transactions_data['user_id']]['cc_emails'] = $transactions_data['installer']->billing_addres->cc_emails;
                    }
                }

                // Create array for insert in billing table
                $k = 0;
                foreach ($billing_arr as $userId => $billing_arr_data) {
                    $billing_data[$k]['user_id'] = $userId;
                    $billing_data[$k]['amount'] = $billing_arr_data;
                    $billing_data[$k]['month_year'] = $last_month_year;
                    $billing_data[$k]['created'] = $invoice_date;

                    $k++;
                }
                $billings = $this->Billings->newEntities($billing_data);
                if ($this->Billings->saveMany($billings)) {
                    foreach ($billings as $billings_data) {

                        $this->Transactions->query()
                                ->update()
                                ->set(['billing_id' => $billings_data->id])
                                ->where(['user_id' => $billings_data->user_id])
                                ->where(['DATE_FORMAT(created,"%Y-%m") = "' . date('Y-m', strtotime("-1 month")) . '"'])
                                ->execute();

                        // Create Invoice PDF and save in folder
                        $this->billingPdf($billings_data->id);

                        // Invoice Pdf link
                        $invoice_pdf = ROOT . DS . 'webroot' . DS . 'pdf' . DS . $billings_data->month_year . DS . 'Invoice' . $billings_data->id . '_' . $billings_data->user_id . '.pdf';
                        // Send Invoice Email
                        $this->getMailer('Manu')->send('billing_invoice', [$invoice_pdf, $installer_info[$billings_data->user_id]]);
                    }
                }
            }
        }
    }

    /*
     * Billing Method
     */

    public function billing() {

        // Current day
        $current_day = date('d');

        // outstanding amount
        $outstanding_amount = $this->Billings->find()->select(['amount', 'month_year'])
                ->where(['status' => 0]);

        // Current outstanding

        $outstanding_current = $this->Transactions->find()
                        ->select(['month' => 'MONTH(Transactions.created)', 'total_amount' => $this->Transactions->find()->func()->sum('amount')])
                        ->where(['DATE_FORMAT(Transactions.created,"%Y-%m") >= "' . date('Y-m', strtotime("-1 month")) . '"', 'DATE_FORMAT(Transactions.created,"%Y-%m") <= "' . date('Y-m') . '"'])
                        ->group(['MONTH(Transactions.created)'])->toArray();
        $outstanding_current_amount = [];
        if (!empty($outstanding_current)) {
            foreach ($outstanding_current as $outstanding_current_data) {
                $outstanding_current_amount[$outstanding_current_data->month] = $outstanding_current_data->total_amount;
            }
        }

        // Seraching Invoices
        $query = $this->Billings->find();
        $conditions = [];
        if (isset($this->request->query['status']) && $this->request->query['status'] != "") {
            $conditions[] = ['Billings.status' => $this->request->query['status']];
        }
        if (isset($this->request->query['current_month']) && $this->request->query['current_month'] != "") {
            $this->request->query['from_date'] = date('Y-m-01');
            $this->request->query['to_date'] = date('Y-m-t');
        }
        if (isset($this->request->query['from_date']) && !empty($this->request->query['from_date'])) {
            $conditions[] = ['DATE(Billings.created) >= ' => $this->request->query['from_date']];
        }
        if (isset($this->request->query['to_date']) && !empty($this->request->query['to_date'])) {
            $conditions[] = ['DATE(Billings.created) <= ' => $this->request->query['to_date']];
        }
        if (!empty($this->request->query)) {
            $this->request->data = $this->request->query;
        }
        $query->contain(['Installers' => function($q) {
                return $q->select(['id'])
                                ->contain(['InstallerCompanyDetail' => function($q) {
                                        return $q->select(['company_name']);
                                    }]);
            }]);


        $query->where($conditions);
        $billings = $this->paginate($query);

        // All leads

        $query = $this->Transactions->find();
        $leads = $this->Transactions->find()->select(['user_id', 'gst', 'total_lead' => $query->func()->count('Transactions.lead_id'), 'total_amount' => $query->func()->sum('Transactions.amount'), 'Installers.id', 'InstallerCompanyDetail.company_name'])
                ->contain(['Installers', 'Installers.InstallerCompanyDetail'])
                ->where(['DATE_FORMAT(Transactions.created,"%Y-%m") = "' . date('Y-m') . '"'])
                ->group('Transactions.user_id');


        // Prevoius leads
        if ($current_day < Configure::read('InvoiceDate')) {
            $previous_leads = $this->Transactions->find()->select(['user_id', 'gst', 'total_lead' => $query->func()->count('Transactions.lead_id'), 'total_amount' => $query->func()->sum('Transactions.amount'), 'Installers.id', 'InstallerCompanyDetail.company_name'])
                    ->contain(['Installers', 'Installers.InstallerCompanyDetail'])
                    ->where(['DATE_FORMAT(Transactions.created,"%Y-%m") = "' . date('Y-m', strtotime("-1 month")) . '"'])
                    ->group('Transactions.user_id');
        }

        $dateformat = Configure::read('Setting.admin_date_format');
        $this->set(compact('billings', 'leads', 'previous_leads', 'outstanding_amount', 'outstanding_current_amount', 'dateformat'));
        $this->set('_serialize', ['billings', 'leads', 'previous_leads']);
    }

    /*
     * Feedback Method
     *  Show all type feedback data
     */

    public function feedback($id = null) {

        // Converted feedback 
        $converted_data = $this->ConvertedLeads->find()
                        ->contain(['Installers' => function($q) {
                                return $q->select(['id'])
                                        ->contain(['InstallerCompanyDetail' => function($q) {
                                                return $q->select(['company_name']);
                                            }]);
                            }])
                        ->where(['lead_id' => $id, 'type' => 0])->toArray();
        // 40 days feedback 
        $feedback_data_q = $this->ConvertedLeads->find()
                ->contain(['Installers' => function($q) {
                        return $q->select(['id'])
                                ->contain(['InstallerCompanyDetail' => function($q) {
                                        return $q->select(['company_name']);
                                    }]);
                    }])
                ->where(['lead_id' => $id, 'type' => 1]);
        $feedback_data = $feedback_data_q->first();

        // Customer feedback for installers 
        $customer_feedback = $this->LeadsUsers->find()
                        ->select(['user_id', 'feedback'])
                        ->contain(['Installers' => function($q) {
                                return $q->select(['id'])
                                        ->contain(['InstallerCompanyDetail' => function($q) {
                                                return $q->select(['company_name']);
                                            }]);
                            }])
                        ->where(['lead_id' => $id, 'feedback <>' => ''])->toArray();


        $dateformat = Configure::read('Setting.admin_date_time_format');
        $this->set(compact('id', 'converted_data', 'feedback_data', 'customer_feedback', 'dateformat'));
        $this->set('_serialize', ['lead']);
    }

    /*
     * Change Billing Status from outstanding to paid
     */

    public function billing_status() {
        $billing = $this->Billings->get($_REQUEST['id']);
        $billing->status = 1;
        $this->Billings->save($billing);
        die;
    }

    /*
     * Lead rejection approved by admin
     */

    public function rejection_approved() {
        $leadsusers = $this->LeadsUsers->get($_REQUEST['id']);
        $leadsusers->rejection_approved = 1;
        if ($this->LeadsUsers->save($leadsusers)) {
            $leadId = $leadsusers->lead_id;
            $userId = $leadsusers->user_id;

            $this->Transactions->deleteAll(array('Transactions.user_id' => $userId, 'Transactions.lead_id' => $leadId), false);
        }
        die;
    }

    /*
     * Generate billing invoice pdf
     */

    public function billingPdf($id = null) {
        
        $this->viewBuilder()->layout('ajax');

        $billing = $this->Billings->get($id, [
            'contain' => ['Transactions' => ['Leads'], 'Installers' => function($q) {
                    return $q
                                    ->select(['id'])
                                    ->contain(['InstallerCompanyDetail']);
                }]
        ]);

        
        
        // Generate PDF by API
        
       $path = ROOT . DS . 'webroot' . DS . 'pdf' . DS . $billing->month_year;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        $pdfname = 'Invoice' . $billing->id . '_' . $billing->user_id . '.pdf';
        
        $file_location = $path . '/' . $pdfname;

       // $apikey = '4f5d0ee7-cd29-4369-b59c-b04b3e0592f9';
        $apikey = '49d7b0db-1e22-44ac-98d0-a2032c7309e3';
        $value = 'http://ds13.projectstatus.co.uk/solarpanel/crm/admin/leads/invoice/'.$id; // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
        $result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey={$apikey}&value={$value}");
        file_put_contents($file_location, $result);

        // Generate PDF

    }
    
     public function invoice($id = null) {
      $this->viewBuilder()->layout('pdflayout'); 
      
      $billing = $this->Billings->get($id, [
            'contain' => ['Transactions' => ['Leads'], 'Installers' => function($q) {
                    return $q
                                    ->select(['id'])
                                    ->contain(['InstallerCompanyDetail']);
                }]
        ]);
                
    $ConfigSettings = $this->ConfigSettings;
     $dateformat = Configure::read('Setting.admin_date_format');           
      $this->set(compact('billing', 'ConfigSettings','dateformat'));
    }

    public function pdfhtml_dev() {
        $this->viewBuilder()->layout('ajax');

        $path = ROOT . DS . 'webroot' . DS . 'pdf' . DS . 'September, 2017' . DS . 'mypdf14_dev.pdf';

       // $apikey = '4f5d0ee7-cd29-4369-b59c-b04b3e0592f9';
        $apikey = '49d7b0db-1e22-44ac-98d0-a2032c7309e3';
        $value = 'http://ds13.projectstatus.co.uk/solarpanel/crm/admin/leads/pdfhtml'; // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
        $result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey={$apikey}&value={$value}");
        file_put_contents($path, $result);
        
    }
    public function pdfhtml() {
      $this->viewBuilder()->layout('pdflayout'); 
    }

}