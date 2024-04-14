 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title> Book Site</title>
     <meta name="description" content="Your website description here">
     <meta name="keywords" content="keywords, here, separated, by, commas">
     <meta name="author" content="Pratik">
     <link rel="icon" href="assets/img/fab.jpg" type="image/x-icon">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
     <link id="css-link" rel="stylesheet" type="text/css" href="">


     <script>
         // Default CSS file
         var defaultCSS = 'assets/css/style1.css';
         // Function to toggle between CSS files
         function toggleCSS() {
             var currentCSS = localStorage.getItem('currentCSS');
             var newCSS;

             // Check which CSS file is in use and toggle 
             if (currentCSS === 'assets/css/style1.css') {
                 newCSS = 'assets/css/style2.css';
             } else {
                 newCSS = 'assets/css/style1.css';
             }

             // Set the new CSS file in the localStorage
             localStorage.setItem('currentCSS', newCSS);
             document.getElementById('css-link').setAttribute('href', newCSS);
         }

         // On page load, check if there is CSS file in localStorage 
         document.addEventListener('DOMContentLoaded', function() {
             var currentCSS = localStorage.getItem('currentCSS') || defaultCSS; 
             if (currentCSS) {
                 document.getElementById('css-link').setAttribute('href', currentCSS);
             } else {
                 localStorage.setItem('currentCSS', 'assets/css/style1.css');
                 document.getElementById('css-link').setAttribute('href', 'assets/css/style1.css');
             }
         });
     </script>
 </head>

 <body>
     <section class="navigation">
         <div class="nav-container">
             <div class="brand" onclick="toggleCSS()">
                 <span href="/">BOOKBUDDY</span>
             </div>
             <nav>
                 <div class="nav-mobile">
                     <a id="navbar-toggle" href="#!"><span></span></a>
                 </div>
                 <ul class="nav-list" id="nav-list">
                     <li>
                         <a href="index.php">Home</a>
                     </li>
                     <li>
                         <a href="about.php">About</a>
                     </li>
                     <li>
                         <a href="booklist.php">Books table</a>
                     </li>
                     <li>
                         <a href="authen.php">Add book</a>
                     </li>
                     <li>
                         <a href="contact.php">Contact</a>
                     </li>


                 </ul>
             </nav>
         </div>
     </section>