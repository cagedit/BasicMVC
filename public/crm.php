<?php
class CRM
{
	private static $indexes = [];

	private static function getData()
	{
		$content = file_get_contents('crm.csv');
		$content = explode("\n", $content);
		while (!empty($content)) {
			$rows[] = str_getcsv(current($content));
			unset($content[key($content)]);
		}

		// foreach ($rows[0] as $titles) {
		// 	if
		// }
		// die();

		return $rows;
	}

	public static function makeTable()
	{
		$rows = self::getData();
		ob_start();
		?>
		<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
		<style>
		.table {
			font-size: 11px;
		}
		</style>
		<table class="table table-striped">
			<thead>
				<?php foreach($rows[0] as $title): ?>
					<th><?=$title?></th>
				<?php endforeach; unset($rows[0]); ?>
			</thead>
			<tbody>
				<?php foreach($rows as $row): ?>
					<tr>
					<?php foreach ($row as $cell): ?>
						<td><?=$cell?></td>
					<?php endforeach; ?>
					</tr>
				<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
		<?php
		echo ob_get_clean();
	}
}

CRM::makeTable();