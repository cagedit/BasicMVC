@extends('master')
@section('subsection')
<p>
This data exists in the sub file
<form method="POST">
	<input type="text" name="anything">
</form>
</p>
@endsection

@section('somethingElse')
there is more content to show
@endsection

@section('notincluded')
there are more things to say
@endsection