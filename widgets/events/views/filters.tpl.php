<ul class="list-inline no-margin">
	<li><?php echo icon('fa-sliders'); ?></li>
	<li><a href="<?php echo url(($this->url->admin) ? 'admin/events' : 'events'); ?>"><?php echo ($this->url->request == 'events' || $this->url->request == 'admin/events') ? '<b>All</b>' : 'All'; ?></a></li>
	<li><a href="<?php echo url(($this->url->admin) ? 'admin/events/standards' : 'events/standards'); ?>"><?php echo ($this->url->request == 'events/standards' || $this->url->request == 'admin/events/standards') ? '<b>Standards</b>' : 'Standards'; ?></a></li>
	<li><a href="<?php echo url(($this->url->admin) ? 'admin/events/matches' : 'events/matches'); ?>"><?php echo ($this->url->request == 'events/matches' || $this->url->request == 'events/matches/list' || $this->url->request == 'admin/events/matches') ? '<b>Matches</b>' : 'Matches'; ?></a></li>
	<li><a href="<?php echo url(($this->url->admin) ? 'admin/events/upcoming' : 'events/upcoming'); ?>"><?php echo ($this->url->request == 'events/upcoming' || $this->url->request == 'events/upcoming/list' || $this->url->request == 'admin/events/upcoming') ? '<b>Upcoming</b>' : 'Upcoming'; ?></a></li>
</ul>