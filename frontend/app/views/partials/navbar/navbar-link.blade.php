<!-- Show hover titles for small and medium screens -->
<li class="hidden-xs hidden-lg" title="[[ $title ]]">
	<a href="[[ $route ]]" class="transition-effect">
		<i class="fa [[ $fa_icon ]]"></i>
	</a>
</li>

<!-- Show actual titles for large and extra small screens -->
<li class="hidden-sm hidden-md">
	<a href="[[ $route ]]" class="transition-effect">
		<i class="fa [[ $fa_icon ]]"></i>
		<span>
			[[ $title ]]
		</span>
	</a>
</li>
