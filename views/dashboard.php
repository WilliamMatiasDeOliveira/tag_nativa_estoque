<?php
include("../layouts/header.php");
include("../layouts/nav.php");
?>
<style>
    body {
        overflow: hidden;
    }

    .marquee {
        /* background-color: red; */
        text-align: center;
        margin-top: 12%;
        width: 100%;
        overflow: hidden;
        white-space: nowrap;
        animation: marquee 15s linear infinite;
        font-weight: bold;
        color: #141234;
    }



    @keyframes marquee {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }
</style>




<div class="marquee">
    <h1>Tag_Nativa Sistemas</h1>
    <p>(014) 99999 - 4444</p>
</div>



<?php
include("../layouts/footer.php");
?>