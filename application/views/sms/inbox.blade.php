@layout('profiles.person_profile_template')
@section('content')
<div class="container-fluid">
<section class="comment-list block">
	<!-- comment form -->
	<article class="comment-item media" id="comment-form">
	  <a class="pull-left thumb-small avatar"><img src="http://www.gravatar.com/avatar/{{ md5( strtolower( trim( Auth::user()->email ) ) ) }}&s=32" class="img-circle"></a>
	  <section class="media-body">
	    <form action="" method="post" class="m-b-none">
	      <div class="input-group">
	        <input type="text" name="comment" placeholder="{{ __('profile.placeholder.comment') }}" class="form-control">
	        <span class="input-group-btn">
	          <button class="btn btn-primary" type="submit">{{ __('profile.post') }}</button>
	        </span>
	      </div>
	    </form>
	  </section>
	</article><br /><br />
	@foreach($sms as $message)
	<?php #if($message->user()->first()->id == 1) continue; ?>
	<div class="row">
		<div class="col-xs-6{{ $message->type == 'outbound' ? ' pull-right' : '' }}">
			<article id="comment-id-1" class="comment-item media">
			  <section class="media-body panel{{ $message->type == 'inbound' ? ' bg-info' : '' }}">
			  	@if($message->type == 'outbound')
			  	<header class="panel-heading clearfix">
			  		<strong>{{ $message->user()->first()->name }}</strong>
			      <span class="text-muted m-l-small pull-right">
			        <i class="fa fa-clock-o"></i>
			        {{ Date::nice($message->created_at) }}
			      </span>
			    </header>
			    @endif
			    <div class="panel-body">
					{{ $message->message }}
			    </div>
			  </section>
			</article>
		</div>
	</div>
	@endforeach
</section>
</div>
@endsection