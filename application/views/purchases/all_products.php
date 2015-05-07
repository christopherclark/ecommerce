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
            /*border: 3px solid black;*/
        }
        .thumbnail {
            border: none;
            max-height: 180px;
            max-width: 140px;
        }
        .thumbnail > div > p {
            font-size: 0.85em;
        }
        .raw_image {
            max-height: 120px;
            max-width: 120px;
        }
        .sidebar h4 {
            margin-left: 10px;
        }
        .sidebar {
            padding-bottom: 30px;
        }
        .sort_by, .sidebar input, .sidebar button {
            margin-top: 15px;
        }
        .categories input[type='submit'] {
            background-color: white;
            border: none;
        }
    </style>
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('change', '.sort_by', 
                function() {
                    $(this).submit();
                }
            );
        });

    </script>
</head>
<body>
	<?php include('partials/purchases_nav.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="sidebar col-md-3 col-sm-3 col-xs-3">
                <!-- SEARCH BAR -->
                <div class="row">
                    <div class="col-lg-12">
                        <form action="/purchases/get_products_by_name" method="post">
                            <div class="input-group">
                                <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                <input type="hidden" name="page_no" value="1">
                                <input type="hidden" name="category_id" value="0">
                                <input type="text" class="form-control" name="search_val" placeholder="product name">
                                <span class="input-group-btn">
                                <input type="submit" class="btn btn-default" value="Go!">
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- CATEGORIES NAV -->
                <div class="row">
                    <h4>Categories</h4>
                    <ul class="categories nav nav-pills nav-stacked">
                        <?php foreach ($category_counts as $category) { ?>
                        <li role="presentation">
                            <form action="/purchases/view_product_category_by_page" method="post">
                                <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                <input type="hidden" name="page_no" value="1">
                                <input type="hidden" name="category_id" value="<?=$category['category_id']?>">
                                <input type="submit" value="<?=$category['category_name']?> (<?=$category['category_count']?>)">
                            </form>
                        </li>
                        <?php } ?>
                        <li role="presentation">
                            <form action="/purchases/view_product_category_by_page" method="post">
                                <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                <input type="hidden" name="page_no" value="1">
                                <input type="hidden" name="category_id" value="0">
                                <input type="submit" value="Show All">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="products col-md-7 col-sm-7 col-xs-7">
                <!-- THUMBNAILS -->
                <div class="row">
                    <div class="col-md-8">
                        <h2><?=$category_name?> (page <?=$page_no?>)</h2>
                    </div>
                    <div class="col-md-4 pull-right">
                        <form class="sort_by" action="/purchases/sort_by" method="post">
                            <input type="hidden" name="page_no" value="1">
                            <input type="hidden" name="category_id" value="<?=$category_id?>">
                            <label for="sort_by">Sorted by</label>
                            <select name="sort_by">
                                <option value="Price"<?php if($sort_by=='Price'){ echo ' selected'; } ?>>Price</option>
                                <option value="Most Popular"<?php if($sort_by=='Most Popular'){ echo ' selected'; } ?>>Most Popular</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <?php
                    $count = 0;
                    foreach ($products as $product) { 

                        if ($count%4 == 0) {
                            echo "<div class='row'>";
                        }
                    ?>
                        <a href="/products/show/<?=$product['id']?>">
                            <div class="thumbnail col-md-3 col-sm-3 col-xs-2">
                                <img class="raw_image" src="<?=$product['link']?>" alt="thumbnail">
                                <p class="overlay_text">$<?=$product['price']?></p>
                                <div class="caption">
                                    <p>(<?=$product['quantity_sold']?>) <?=$product['name']?></p>
                                </div>
                            </div>
                        </a>
                    <?php 

                        $count++;
                        if ($count%4 == 0) {
                            echo "</div>";
                        }

                    } 
                    if ($count%4 != 0) {
                        echo "</div>";
                    }
                    ?>
                </div>
                <!-- PAGINATION NAV -->
                <div class="row col-centered">
                    <ul class="pagination col-md-10 col-md-offset-1">
                        <li>
                            <form action="/purchases/view_product_category_by_page" method="post">
                                <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                <input type="hidden" name="page_no" value=1>
                                <input type="hidden" name="category_id" value="<?=$category_id?>">
                                <input type="submit" value="first">
                            </form>
                        </li>
                        <?php 
                            // get max page from the product count that matches the given category
                            $matched_product_count = 0;
                            foreach ($category_counts as $category) {
                                if ($category_id == 0) {
                                    $matched_product_count += $category['category_count'];
                                }
                                else if ($category['category_id'] == $category_id) {
                                    $matched_product_count += $category['category_count'];
                                }
                            }
                            $max_page = ceil($matched_product_count / 8);
                            for ($page=1; $page<=$max_page; $page++) { ?>
                            <li>
                                <form action="/purchases/view_product_category_by_page" method="post">
                                    <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                    <input type="hidden" name="page_no" value="<?=$page?>">
                                    <input type="hidden" name="category_id" value="<?=$category_id?>">
                                    <input type="submit" value="<?=$page?>">
                                </form>
                            </li>
                        <?php } ?>
                        <li>
                            <form action="/purchases/view_product_category_by_page" method="post">
                                <input type="hidden" name="sort_by" value="<?=$sort_by?>">
                                <input type="hidden" name="page_no" value="<?=$max_page?>">
                                <input type="hidden" name="category_id" value="<?=$category_id?>">
                                <input type="submit" value="last">
                            </form>
                        </li>
                        <?php
                        echo "category_id:<br>";
                            var_dump($category_id);
                            echo "max_page:<br>";
                            var_dump($max_page);
                            ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</body>
</html>