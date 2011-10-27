<h1>Welcome to the actors index</h1>
<p>
<a href="/actors/add/">Create Actor</a> 
| <a href="/actors/flush/" onClick="return confirm('Flushing the data will reset the json db to default settings.\n Are you sure?');">Flush Data</a>
</p>

<h3>Filter</h3>
<?=$this->Form->create('', array('action' => 'index')); ?>
<table>
	<tr>
		<td>Last Name</td>
		<td><input type="text" name="Filter['LastName']" value="<?php print htmlentities($filters['LastName']); ?>" /></td>
	</tr>

	<tr>
		<td>Billing Rate</td>
		<td><input type="text" name="Filter['BillingRate']" value="<?php print htmlentities($filters['BillingRate']); ?>" /></td>
	</tr>
</table>

<?= $this->Form->end('Filter Records'); ?>

<h3>Actors List: <?=count($actors)?></h3>
<table>
	<tr>
		<th>Actor</th>
		<th>Billing Rate</th>
		<th>Role</th>
		<th>Interview Date</th>
		<th>&nbsp;</th>
	</tr>

	<?php foreach ($actors AS $actor) : ?>
		<tr>
			<td><?php print "{$actor['firstName']} {$actor['lastName']}"; ?></td>
			<td><?php print $actor['billingRate']; ?></td>
			<td><?php print $actor['role']; ?></td>
			<td><?php print date('l jS \of F Y h:i:s A', $actor['interviewDate']); ?></td>
			<td><?php 
                printf('<a href="/actors/edit/%1$d">Edit this record</a> ' .
                       '| <a href="/actors/delete/%1$d" onClick="return confirm(\'Are you sure you want to delete this record?\');">Delete</a>',
                       $actor['id']);
				?></td>
		</tr>
	<?php endforeach; ?>

</table>

<p>
<a href="/actors/add/">Create Actor</a> 
| <a href="/actors/flush/" onClick="return confirm('Flushing the data will reset the json db to default settings.\n Are you sure?');">Flush Data</a>
</p>
