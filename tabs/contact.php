<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pagina de Joc</title>
        <link rel="stylesheet" href="../css/contact.css">
    </head>
    <body>
        <header>
            <div class="logo">
                <a href="home.php" class="logo-link">
                    <img src="../assets/logo.png" alt="Logo" class="logo-img">
                </a>
            </div>
        </header>
        
        <main>
            <div class="sub-header"> 
                <h1>Contact Us</h1>

                <section class="location">

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54212.58671220446!2d24.338688486840788!3d44.4290982048693!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40ad38307c82022d%3A0xc78ff75e3542c846!2sSlatina!5e0!3m2!1sen!2sro!4v1724617099712!5m2!1sen!2sro" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>


                </section>

                <section class="contact-us">
                    <div class="row">
                        <div class="contact-col">
                            <div>
                                <i class="fa-solid fa-house"></i>
                                    <span>
                                        <h5>Str Cornisei, nr9, GA2</h5>
                                        <p>Slatina, Olt, RO</p>
                                    </span>
                            </div>
                            <div>
                                <i class="fa-solid fa-phone"></i>
                                    <span>
                                        <h5>+40773884804</h5>
                                        <p>Monday to Friday, 8AM to 4PM</p>
                                    </span>
                            </div>
                            <div>
                                <i class="fa-solid fa-envelope"></i>
                                    <span>
                                        <h5>liviu.razvan2510@yahoo.com</h5>
                                        <p>Email us your query</p>
                                    </span>
                            </div>
                        </div>
                        <div class="contact-col">
                            <form action="form-handler.php" method="post">
                                <input type="text" name="name" placeholder="Enter your name" required>
                                <input type="email" name="email" placeholder="Enter email adress" required>
                                <input type="text" name="subject" placeholder="Enter your subject" required>
                                <textarea rows="8" name="message" placeholder="Message" required></textarea>
                                <button type="submit" class="hero-btn red-btn">Send Message</button>
                            </form>



                        </div>
                    </div>

                </section>

                

            </div>

        
 

        </main>
        <div id="bubble-wrapper">
  
    </div>

    <footer id="footer">
    <div id="footer-content">
        <div class="footer-section">
        <h3 class="footer-section-title">General</h3>
        <div class="footer-section-links">
            <a href="games.php" >Games</a>
            <a href="about.php" >About</a>
            <a href="contact.php" >Contact Us</a>
        </div>
        </div>
        <div class="footer-section">
        <h3 class="footer-section-title">Social</h3>
        <div class="footer-section-links">
            <a href="https://x.com/flerezzbot" >Twitter</a>
            <a href="https://www.instagram.com/razvan.liviu/" >Instagram</a>
            <a href="https://www.youtube.com/@RazvanLiviu25" >YouTube</a>
        </div>
        </div>
        <div class="footer-section">
        <h3 class="footer-section-title">Author</h3>
        <div class="footer-section-links">
            <a>Tuca Liviu</a>
            <a>Razvan</a>
            <a>Stefanut</a>
        </div>
        </div>
    </div>
    </footer>

    <script src="../js/contact.js"></script>
    </body>
</html>