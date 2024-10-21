<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Өвөрхангай ПК</title>
    <meta name="twitter:title" content="<?=$pageTitle?>">
    <meta property="og:title" content="<?=$pageTitle?>">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="./static/css/main.css">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- IT'S DANGEROUS TO GO ALONE! TAKE THIS EASTER EGG. -->
    <div id="main">

        <div id="photo-menu">
            <p>Багш ажилтнуудын зурган дээр дарах, чирэх үйлдэл хийж харж болно. <i id="pause-button" class="fas fa-pause"></i></p>
            <button id="helix">ТОЙРОГ</button>
            <button id="sphere">БӨМБӨРЦӨГ</button>
            <button id="grid">ШОО</button>
            <button id="table">ХҮСНЭГТ</button>
        </div>
        <script type="text/javascript" src="./static/js/urlParams.js"></script>
        <script type="module">
            import { init, animate } from "./static/js/photography/photoDisplay.js";
            getData();
            async function getData() {
                const url = "http://college.mn/api/get_users";
                try {
                    const response = await fetch(url, {
                        mode: 'no-cors'
                    });
                    console.log(response);
                    if (!response.ok) {
                        throw new Error(`Response status: ${response.status}`);
                    }

                    const json = await response.json();
                    console.log(json);

                    $('#photoDisplayModal').on("hidden.bs.modal", function () {
                        removeUrlParam("id");
                    });
                    init(json);
                    animate();
                    $("#helix").click();
                    // Add view=id to URL on View click
                    $(document).ready(function () {
                        // If URL contains view query param open respective modal on page load
                        let id = getUrlParam('id');
                        if (id) {
                            $("#photo" + id).click();
                        }
                    });

                    // Previous/next button
                    $(".fa-angle-left").on("click", function () {
                        let id = parseInt(getUrlParam('id'));
                        $("#myModal").modal('hide');
                        removeUrlParam("id");
                        id--;
                        $("#photo" + id).click();
                    });
                    $(".fa-angle-right").on("click", function () {
                        let id = parseInt(getUrlParam('id'));
                        $("#myModal").modal('hide');
                        removeUrlParam("id");
                        id++;
                        $("#photo" + id).click();
                    });
                } catch (error) {
                    console.error(error.message);
                }
            }
        </script>
        <script type="module" src="./static/js/photography/buttons.js"></script>

        <!-- Modal -->
        <div class="modal fade" id="photoDisplayModal" tabindex="-1" role="dialog"
            aria-labelledby="photoDisplayModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="photoDisplayModalLabel"></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-date">
                        <div class="row">
                            <div class="col-md-6">
                                <h6></h6>
                            </div>
                            <div class="col-md-6">
                                <a class="btn fab fa-instagram fa-lg float-right" target="_blank"></a>

                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <img>
                    </div>
                    <div class="modal-buttons">
                        <i class="fas fa-angle-left float-left"></i>
                        <i class="fas fa-angle-right float-right"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            // HACK: This pushes the footer lower on the contact page if it's
            // on mobile but isn't a permanent solution as it needs the images
            // to load first and just isn't a good solution overall
            window.addEventListener('load', function () {
                if (window.innerWidth < 640) {
                    var footer = document.getElementById("footer");
                    footer.style.marginTop = "9em";
                }
            })

        </script>

    </div>

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top container">
        <button class="navbar-toggler text-right" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse text-right" id="navbarNav">
            <a class="navbar-brand" href="/home"><?=$school_name?>- Манай хамт олон</a>
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#"></a>
                </li>
            </ul>
        </div>
    </nav>

    <script>
        var transparent = true;
        var hamburgerButton = document.querySelector("nav button");
        var navBar = document.getElementsByTagName("nav")[0];

        // Dynamically make collapsible navbar transparent or opaque on hamburger press
        hamburgerButton.addEventListener("click", function () {
            if (transparent) {
                navBar.style.backgroundColor = "rgba(0,0,0,0.8)";
            } else {
                setTimeout(function () { navBar.style.backgroundColor = "transparent"; }, 350);
            }
            transparent = !transparent;
        });
    </script>
    <div id="footer">

    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>