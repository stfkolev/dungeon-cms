<div class="<?php echo $data['align']; ?>">
	<h2 class="site-title"<?php if (!empty($data['color-title'])) echo 'style="color: '.$data['color-title'].'"'; ?>><?php echo $data['title'] ?: $this->config->dungeon_name; ?></h2>
	<h5 class="site-description"<?php if (!empty($data['color-description'])) echo ' style="color: '.$data['color-description'].'"'; ?>><?php echo $data['description'] ?: $this->config->dungeon_description; ?></h5>
</div>