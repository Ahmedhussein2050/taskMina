<?php $__env->startSection('content'); ?>
<div class="flash-message">
	<?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<?php if(session()->has($msg)): ?>
	<p class="alert alert-<?php echo e($msg); ?>"><?php echo e(session()->get($msg)); ?></p>
	<?php endif; ?>
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="page-body">
	<div class="card blog-page" >
		<div class="card-block ">
				<?php echo $__env->make('admin.layout.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="dt-responsive table-responsive text-center">
				<table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
					width="100%">
					<thead>
						<tr role="row">
							<th><?php echo e(_i('ID')); ?></th>
							<th><?php echo e(_i('Image')); ?></th>
							<th><?php echo e(_i('type')); ?></th>
							<th><?php echo e(_i('User')); ?></th>
							<th><?php echo e(_i('status')); ?></th>
							<th><?php echo e(_i('Order Number')); ?></th>
							<th><?php echo e(_i('Total')); ?></th>
							<th><?php echo e(_i('shipping cost')); ?></th>
							<th><?php echo e(_i('Order Time')); ?></th>
							<th><?php echo e(_i('action')); ?></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
<?php $__env->startPush('js'); ?>
<script type="text/javascript">

	var table;
	function init(url = "<?php echo e(route('admin.orders.index')); ?>")
	{
		table = $('#order_data').DataTable(
		{
			// "order": [],
			dom: "Blfrtip",
			buttons:
			[
				
				
				
				
				
				
				
				{"extend": "print", "className": "btn btn-primary", "text": "<i class=\"ti-printer\"><\/i>"},
				{
					"text":"<?php echo e(_i('Reset')); ?>", "className":"btn btn-inverse",
					action: function (e, dt, button, config)
					{
						reset()
					}
				},
				{"extend": "collection", "className": "btn btn-inverse", "text": "<?php echo e(_i('Status')); ?>",
					buttons: [
						<?php $__currentLoopData = $orderstatus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						{
							text: "<?php echo e($order); ?>",
							"className": "btn btn-inverse",
							action: function (e, dt, button, config)
							{
								filterByStatus(button.text())
							}
						},
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					]
				},
				{"extend": "collection", "className": "btn btn-inverse", "text": "<?php echo e(_i('Shipping Options')); ?>",
					buttons: [
						<?php $__currentLoopData = $shipping_option; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						{
							<?php
							$company =  App\Modules\Orders\Models\Shipping\ShippingCompaniesData::where('shipping_company_id',$type->company_id)
							->where('lang_id' ,\App\Bll\Lang::getSelectedLangId())->first();
							?>
							text: "<?php if($company != null): ?><?php echo e($company->title); ?> <?php endif; ?> <?php echo e(_i('delay') ." ". $type->delay); ?>",
							"className": "btn btn-inverse",
							action: function (e, dt, button, config)
							{
							   filterByShipping('<?php echo e($type->id); ?>');
							}
						},
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					]
				},
				{
					"text":"<?php echo e(_i('Show All')); ?>", "className":"btn btn-inverse",
					action: function (e, dt, button, config)
					{
						window.location = "../all_orders";
					}
				},

			],
			"order":[[0,'asc']],
			"responsive": true,
			"processing": true,
			"serverSide": true,
			ajax: {
				url: url,
			},
			columns: [
				{data: 'id'},
				{data: 'user_image'},
				{data: 'type'},
				{data: 'user'},
				{data: 'status'},
				{data: 'ordernumber'},
				{data: 'total'},

				{data: 'shipping_cost'},
				{data: 'created_at'},
				{
					data: 'action',
					orderable: false,
					searchable: false
				}
			],
			'drawCallback': function () {
			}
		});
	}
	$(function () {
		init();
	});

	function reset()
	{
		table.destroy();
		init('<?php echo e(route('admin.orders.index')); ?>');
	}
	function showAll()
	{
		table.destroy();
		init('<?php echo e(route('admin.orders.index')); ?>?allOrders=yes');
	}

	function filterByStatus(type)
	{
		table.destroy();
		init('<?php echo e(route('admin.orders.index')); ?>?type=' + type);
	}

	function filterByTransaction(type2) {
		table.destroy();
		init('<?php echo e(route('admin.orders.index')); ?>?type2=' + type2);
	}

	function filterByShipping(type3) {
		table.destroy();
		init( '<?php echo e(route('admin.orders.index')); ?>?type3=' + type3);
	}

</script>
<?php $__env->stopPush(); ?>
<style>
	.table {
	display: table !important;
	}
	.row {
	width: 100% !important;
	}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.index',[
	'title' => _i('Orders'),
	'subtitle' => _i('Orders'),
	'activePageName' => _i('Orders'),
	'activePageUrl' => route('admin.orders.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index')
] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\mashora\app\Modules\Orders\views/admin/orders/index.blade.php ENDPATH**/ ?>