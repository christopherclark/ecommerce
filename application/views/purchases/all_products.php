<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/assets/css/purchases.css">
	<title>H&H Supplies - Products</title>
    <style>
        .overlay_text {
            vertical-align: bottom;
            position: absolute;
            top: 55%;
            left: 50%;
            padding: 2px 4px;
            font-weight: 700;
            background-color: black;
            color: white;
            border-radius: 5px;
        }
        .sidebar, .products {
            margin: 20px;
            border: 3px solid black;
        }
        .thumbnail {
            border: none;
        }
        .sidebar h4 {
            margin-left: 10px;
        }
        .sidebar {
            padding-bottom: 30px;
        }
        .sortby, .sidebar input, .sidebar button {
            margin-top: 15px;
        }
    </style>
</head>
<body>
	<?php include('partials/purchases_nav.php'); ?>

    <div class="container-fluid">
        <div class="row">

            <div class="sidebar col-md-3 col-sm-3 col-xs-3">
                <!-- SEARCH BAR -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="product name">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- CATEGORIES -->
                <div class="row">
                    <h4>Categories</h4>
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"><a href="#">Horseshoes (2)</a></li>
                        <li role="presentation"><a href="#">Hand Grenades (1)</a></li>
                    </ul>
                </div>
            </div>

            <div class="products col-md-8 col-sm-7 col-xs-7">
                <!-- THUMBNAILS -->
                <div class="row">
                    <div class="col-md-8">
                        <h2>Horseshoes (page 1)</h2>
                    </div>
                    <div class="sortby col-md-4 pull-right">
                        <label for="sortby">Sorted by</label>
                        <select name="sortby">
                            <option value="price">Price</option>
                            <option value="most_popular">Most Popular</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <?php for($i=0; $i<12; $i++) { ?>
                    <div class="thumbnail col-md-2 col-sm-2 col-xs-2">
                        <img class="raw_image" src="/assets/img/used_horseshoe.png" alt="thumbnail">
                        <p class="overlay_text">$99.99</p>
                        <div class="caption">
                            <p>Used Horseshoe</p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <!-- PAGINATION NAV -->
                <div class="row col-centered">
                    <ul class="pagination col-md-10 col-md-offset-1">
                        <li><a href="#">first</a></li>
                        <li class="active"><a href="#">1</a></li>
                        <?php for ($i=2; $i<=10; $i++) { ?>
                        <li><a href="#"><?=$i?></a></li>
                        <?php } ?>
                        <li><a href="#">last</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>
</html>