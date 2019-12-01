<?php 
header('HTTP/1.0 '.$errCode.' Forbidden');
http_response_code($errCode);
?>

<style>
html, body {
    background-color: #eee;
    font-family: cursive;
}
.header {
    text-align: center;
    color: darkred;
    margin: 0 auto;
    padding-top: 2rem;
}
.header h1 {
    font-size: 30vh;
    margin-bottom: 0;
}
.header p {
    font-size: 7vh;
    text-transform: capitalize;
    font-weight: bold;
    font-variant: small-caps;
    margin-top: 0;
}
.links {
    list-style-type: none;
}
.links li {
    display: inline-block;
    margin: 0 10px;
    padding: 10 12px;
    border: 2px solid teal;
    color: teal;
    transition: all .5s ease;
    border-radius: 6px;
}
.links li:hover {
    background-color: teal;
    color: #fff;
}
.links li > a {
    text-decoration: none;
    color: inherit;
}
</style>

<header class="header">
    <h1><?=$errCode?></h1>
    <p><?=$errMessage?></p>
    <ul class='links'>
        <li>
            <a href='/'>Home</a>
        </li>
        <li>
            <a href='/blog'>Blog</a>
        </li>
        <li>
            <a href='/#contact'>Contact</a>
        </li>
    </ul>
</header>

