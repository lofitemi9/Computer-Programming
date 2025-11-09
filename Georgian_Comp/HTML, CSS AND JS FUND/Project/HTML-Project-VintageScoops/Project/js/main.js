// Got a lot of help online for the js so I barely understand everything
// This loads the logo and the nav for the header
const headerTemplate = `
  <header>
    <div class="logo">
      <a href="index.html">
        <img src="img/vintagescoops_logo_nobg.png" alt="Vintage Scoops logo" />
      </a>
    </div>
    <nav>
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="about.html">About Us</a></li>
        <li><a href="shop.html">Shop</a></li>
        <li><a href="contact.html">Contact</a></li>
      </ul>
    </nav>
  </header>
`;

// This loads the footer section
const footerTemplate = `
  <footer>
    <div class="footer-content">
      <p>&copy; 2025 Vintage Scoops. All rights reserved.</p>
      <div class="footer-links">
        <a href="about.html">About Us</a>
        <a href="contact.html">Contact</a>
        <a href="#">Privacy Policy</a>
      </div>
    </div>
  </footer>
`;

// This loads the header
function insertHeader() {
  const container = document.getElementById('header');
  if (!container) return;
  container.innerHTML = headerTemplate;
  const currentPage = window.location.pathname.split('/').pop();
  const links = container.querySelectorAll('nav a');
  links.forEach((link) => {
    if (link.getAttribute('href') === currentPage) {
      link.classList.add('active');
    }
  });
}

// This loads the footer
function insertFooter() {
  const container = document.getElementById('footer');
  if (!container) return;
  container.innerHTML = footerTemplate;
}

// This is waiting for the load before inserting the contents
document.addEventListener('DOMContentLoaded', () => {
  insertHeader();
  insertFooter();
});