<?php
session_start();
if (isset($_SESSION['loggeduser']) && $_SESSION['loggeduser'][1] == "1") {
    header('Location: admin.php');
    exit();
}

include("control/Controler.php");
$ctrl = Controler::getInstance();
$proizvodi = [];
$kategorije = $ctrl->getKategorija();
if (!isset($_GET['kat'])) {
    $proizvodi = $ctrl->getProizvod();
} else {
    $proizvodi = $ctrl->getProizvodFiler("kategorija_id=" . $_GET['kat']);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Store</title>

    <link rel="stylesheet" href="css/styles.css" type="text/css">
    <script src="https://kit.fontawesome.com/d8531d1ca7.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <div class="okvir">
        <?php include("header.php"); ?>
        <div id="store-okvir">
            <div class="col col-left">
                <div class="left-sidebar">
                    <h2>Categories</h2>
                    <div class="kategorije">
                        <?php
                        while ($row = $kategorije->fetch_object()) :
                        ?>
                            <div class="kat kat_1">
                                <h3>
                                    <a href="store.php?kat=<?php echo $row->ID; ?>">
                                        <?php echo $row->naziv; ?>
                                    </a>
                                </h3>
                            </div>
                        <?php endwhile; ?>

                    </div>
                    <h2>Brands</h2>
                    <div class="brendovi">
                        <div class="brand-name">
                            <ul>
                                <li><a href="#">Razer<span class="desno">10</span></li></a>
                                <li><a href="#">SteelSeries<span class="desno">15</span></li></a>
                                <li><a href="#">Asus<span class="desno">20</span></li></a>
                                <li><a href="#">Dell<span class="desno">25</span></li></a>
                            </ul>
                        </div>
                    </div>
                    <h2>Sorting</h2>
                    <div class="sort">
                        <div class="chb"><input type="checkbox" name="" id="" /><span>Sort by price</span></div>
                        <div class="chb"><input type="checkbox" name="" id="" /><span>Sort by name</span></div>
                        <div class="chb"><input type="checkbox" name="" id="" /><span>Sort by quantity</span></div>
                    </div>
                    <h2><a href="store.php?" id="clear-sort">Clear</a></h2>

                </div>
            </div>
            <div class="col col-right">
                <div class="small-container">
                    <h2>Products</h2>
                    <div class="row">
                        <?php
                        while ($row = $proizvodi->fetch_object()) :
                            $slika = $ctrl->getSlikaSingle($row->slika_id)->fetch_object();

                        ?>
                            <div class="col-4 img">
                                <img src="<?php echo $slika->url ?>" alt="<?php echo $slika->naziv ?>" />
                                <a href="product.php?id=<?php echo $row->ID; ?>">
                                    <h4><?php echo $row->naziv; ?></h4>
                                </a>
                                <div class="raiting">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="far fa-star-half"></i>
                                </div>
                                <p><?php echo $row->cena; ?></p>
                                <form action="dodajUkorpu.php" method="post">
                                    <input type="hidden" name="proizvodKorpaId" value="<?php echo $row->ID;?>">
                                    <input type="submit" name="submitKorpa" value="Dodaj u korpu" class="btnDodaj">
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="cistac"></div>
        <?php include("footer.php"); ?>
    </div>
    <script type="text/javascript" src="js/meni.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
</body>

</html>