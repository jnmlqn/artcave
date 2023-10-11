@if ($variable->lastPage() > 1)
	@if($variable->currentPage() == 1)
		<span style="font-size: 1.6em;" class="text-black">
	    	<
	    </span>
	@else
		<span style="font-size: 1.6em;">
	    	<span value="{{$variable->currentPage()-1}}" class="text-black my-link pointer"><</span>
	    </span>
	@endif

	@for ($i = 1; $i <= $variable->lastPage(); $i++)
	    <span>
	        <span style="font-size: 1.6em;">
	        	&nbsp;<span value="{{$i}}" class="{{$i == $variable->currentPage() ? 'text-gold' : 'text-black'}} my-link pointer">{{ $i }}</span>&nbsp;
	        </span>
	    </span>
	@endfor

	@if($variable->currentPage() == $variable->lastPage())
		<span style="font-size: 1.6em;" class="text-black">
	    	>
	    </span>
	@else
		<span style="font-size: 1.6em;">
	    	<span value="{{$variable->currentPage()+1}}" class="text-black my-link pointer">></span>
	    </span>
	@endif
@endif