


  <div>
    <h5 class="mb-4">productducts</h5>
  </div>
  

  <div class="table-responsive">
    <table id="dataTableExample" class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Status</th>
          <th>Created On</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($allProducts as $product): ?>
        <tr>
          <td><?=ucwords($product->name)?></td>
          <td>
            <?php if($product->status == 'Pending') { ?>
              <span class="badge badge-warning">Pending</span>
            <?php } else if($product->status == 'Active') { ?>
              <span class="badge badge-success">Active</span>
            <?php } else if($product->status == 'Removed') { ?>
              <span class="badge badge-danger">Removed</span>
            <?php } else if($product->status == 'Draft') { ?>
              <span class="badge badge-primary">Draft</span>
            <?php } ?>
          </td>
          <td><?=CustomDateTime::dateFrmatAlt($product->created_at)?></td>
          <td>
            <?php if($product->status !== 'Active') { ?>
              <button class="btn btn-primary btn-sm" onclick="approveProduct(<?=$product->pid?>)">Approve</button>
            <?php } else { ?>
              <button class="btn btn-success btn-sm">Approved</button>
            <?php } ?>
            <a class="btn btn-primary btn-sm" href="<?=Config::ADMIN_BASE_URL()?>product_manager/edit/<?=$product->pid?>"><i class="fa fa-edit"></i></a>
            <button class="btn btn-danger btn-sm" onclick="deletePro(<?=$product->pid?>)"><i class="fa fa-trash"></i></button>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </div>
