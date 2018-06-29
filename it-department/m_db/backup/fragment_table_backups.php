<div style="display: table; width: 100%; max-width: 8in;">
	<div class="w3-container w3-border-bottom" style="display: table-row;">
		<div style="display: table-cell;"><b>Name</b></div>
		<div style="display: table-cell; width: 0px;"></div>
	</div>
	<?php
	foreach (array_reverse(glob('m_db/backup/*.sql')) as $key => $value) {
		?><div class="my-hover-light-grey w3-container" style="display: table-row;">
			<div style="display: table-cell;"><?php echo substr($value, 22); ?></div>
			<div style="display: table-cell; white-space: nowrap;">
				<button title="Edit" class="my-button w3-hover-green" onclick="btnRestore('<?php echo substr($value, 12); ?>')" type="button">
					<i class="far fa-clock"></i>
				</button><button title="Edit" class="my-button w3-hover-green" onclick="btnDelete('<?php echo substr($value, 12); ?>')" type="button">
					<i class="far fa-trash-alt" aria-hidden="true"></i>
				</button>
			</div>
		</div>
		<?php
	}
?></div>