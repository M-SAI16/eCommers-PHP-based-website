<footer class="site-footer">
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .site-footer {
            background-color: #2e2e38;
            color: #f2f2f2;
            padding: 60px 20px;
            font-family: 'Segoe UI', sans-serif;
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .footer-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .site-footer h3 {
            color: #ffffff;
            margin-bottom: 15px;
            font-size: 20px;
            border-left: 4px solid #ff9770;
            padding-left: 10px;
        }

        .footer-about,
        .footer-why,
        .footer-founder {
            flex: 1 1 250px;
        }

        .footer-about p,
        .footer-founder p {
            line-height: 1.6;
        }

        .footer-why ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-why li {
            margin-bottom: 10px;
            font-size: 15px;
        }

        .footer-founder img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .footer-founder a {
            color: #4fc3f7;
            text-decoration: none;
        }

        .footer-founder a:hover {
            text-decoration: underline;
        }

        .footer-extra {
            margin-top: 50px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-extra h3 {
            margin-bottom: 10px;
        }

        .footer-extra p a {
            color: #4fc3f7;
            text-decoration: none;
        }

        .footer-extra p a:hover {
            text-decoration: underline;
        }

        .footer-testimonials {
            background-color: #3d3d4a;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .footer-testimonials blockquote {
            font-style: italic;
            margin: 10px 0;
            color: #dddddd;
        }

        .site-footer .bottom-footer {
            text-align: center;
            margin-top: 20px;       /* reduced */
            padding-top: 10px;      /* reduced */
            padding-bottom: 5px;      /* added */
            border-top: 1px solid #555;
            font-size: 14px;
            color: #aaa;
        }
    </style>

    <div class="footer-container">
        <div class="footer-about">
            <h3>About TechNest</h3>
            <p>TechNest is your trusted destination for cutting-edge electronics at unbeatable value. Whether you're seeking the latest smartphones, accessories, or gadgets, we curate the finest tech to meet your lifestyle needs. Our commitment to innovation, reliability, and customer satisfaction drives everything we do. With secure checkout, fast delivery, and dedicated support, TechNest is where technology meets trust.</p>
        </div>

        <div class="footer-why">
            <h3>Why Choose Us?</h3>
            <ul>
                <li>✓ Trusted by thousands of customers</li>
                <li>✓ Secure checkout & payment</li>
                <li>✓ Friendly customer support</li>
                <li>✓ Fast nationwide shipping</li>
            </ul>
        </div>

        <div class="footer-founder">
            <h3>Meet the Founder</h3>
            <img src="../images/founder.jpg" alt="Founder Image">
            <p><strong>M. Sai Lakshmi</strong><br>Founder of TechNest</p>
            <a href="https://www.linkedin.com/in/malli-reddy-sai-lakshmi-0s6a16" target="_blank">View LinkedIn Profile</a>
        </div>
    </div>

    <div class="footer-extra">
        <div>
            <h3>Need Help?</h3>
            <p>Our support team is here for you 24/7. <a href="../pages/contact.php">Contact Us</a></p>
        </div>

        <div class="footer-testimonials">
            <h3>What Our Customers Say</h3>
            <blockquote>"TechNest made online shopping so easy! Fast shipping and great prices." – A. Sharma</blockquote>
            <blockquote>"Excellent customer service and genuine products. Highly recommend!" – R. Mehta</blockquote>
        </div>
    </div>

    <div class="bottom-footer">
        <p>&copy; <?= date('Y'); ?> TechNest. All rights reserved.</p>
    </div>
</footer>

