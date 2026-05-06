<?php
require_once 'config.php';
require_once 'includes/header.php';

// dynamic sql filter
$where = "WHERE 1";

$location = $_GET['location'] ?? '';
$type     = $_GET['type'] ?? '';
$min      = $_GET['min_price'] ?? '';
$max      = $_GET['max_price'] ?? '';

if(!empty($location)){
    $where .= " AND location LIKE '%$location%'";
}

if(!empty($type)){
    $where .= " AND type='$type'";
}

if(!empty($min)){
    $where .= " AND price >= $min";
}

if(!empty($max)){
    $where .= " AND price <= $max";
}

$result = mysqli_query($link, "SELECT * FROM properties $where ORDER BY created_at DESC");
?>

<h2>All Properties</h2>

<form method="GET" action="index.php" class="row mb-4">
    <div class="col-md-3">
        <input type="text" name="location" class="form-control" placeholder="Search by location" value="<?= $location ?>">
    </div>

    <div class="col-md-2">
        <select name="type" class="form-control">
            <option value="">All Types</option>
            <option value="rent" <?= ($_GET['type'] ?? '') == 'rent' ? 'selected' : '' ?>>Rent</option>
            <option value="sale" <?= ($_GET['type'] ?? '') == 'sale' ? 'selected' : '' ?>>Sale</option> 
        </select>    
    </div>

    <div class="col-md-2">
        <input type="number" name="min_price" class="form-control" placeholder="Min Price" value="<?= $min ?>">
    </div>

    <div class="col-md-2">
        <input type="number" name="max_price" class="form-control" placeholder="Max Price" value="<?= $max ?>">
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="index.php" class="btn btn-secondary">Reset</a>
    </div>
</form>

<?php if(mysqli_num_rows($result) > 0): ?>
    <div class="row">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['title'] ?></h5>
                        <p><strong>Type:</strong> <?= ucfirst($row['type']) ?></p>
                        <p><strong>Price:</strong> Rs. <?= $row['price'] ?></p>
                        <p><strong>Location:</strong> <?= $row['location'] ?></p>
                        <a href="/propertylisting/properties/listing.php?id=<?= $row['id'] ?>" class="btn btn-dark btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php else: ?>
    <p>No properties found.</p>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>