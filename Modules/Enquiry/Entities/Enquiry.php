<?php

namespace Modules\Enquiry\Entities;

use Illuminate\Database\Eloquent\Model;
use App\MrtModels\Branch;
use App\MrtModels\User;
use Kyslik\ColumnSortable\Sortable;

class Enquiry extends Model
{
    use Sortable;
    
    protected $table = 'enquiries';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['contact_name','contact_email','contact_number','status_id','contact_address_line_1','contact_address_line_2','contact_suburb_id','contact_state_id','contact_country_id','contact_postcode','branch_id','assignee_id','owner_id','note','marketing_source_obtained','how_enquiry_was_taken','ip_address','useragent','is_deleted'];
    
    public $sortable = ['contact_name',
                        'created_at',
                        'note'];

    /*
      |--------------------------------------------------------------------------
      | RELATIONS
      |--------------------------------------------------------------------------
     */
    public function users()
    {
         return $this->belongsTo(User::class,'assignee_id');
    }
    
    public function branches()
    {
         return $this->belongsTo(Branch::class,'branch_id');
    }
    
    public function countries()
    {
         return $this->belongsTo('Countries','contact_country_id');
    }
    
    public function states()
    {
         return $this->belongsTo('States','contact_state_id');
    }
    
    public function suburb()
    {
         return $this->belongsTo('Suburb','contact_suburb_id');
    }
    
    public function marketingSources()
    {
         return $this->belongsTo('marketingSources','marketing_source_obtained');
    }
    
    public function enquiryTakens()
    {
         return $this->belongsTo('enquiryTakens','how_enquiry_was_taken');
    }
    
    public function enquiryStatus()
    {
         return $this->belongsTo('enquiryStatus','status_id');
    }
}
