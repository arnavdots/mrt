@if(isset($states))
	 @foreach($states as $key => $value)
		<option value="{{ $key }}" {{ $selected_state == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
	 @endforeach
@endif
 
@if(isset($suburb))
	 @foreach($suburb as $key => $value)
		<option value="{{ $key }}" {{ $selected_suburb == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
	 @endforeach
	 
@endif
