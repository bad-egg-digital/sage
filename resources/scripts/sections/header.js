export default function Header() {
  const body = document.querySelector("body");
  // const menuToggle = document.querySelector(".js-menu-toggle");
  // const menuClose = document.querySelector(".js-menu-close");

  // menuToggle.addEventListener("click", (e) => {
  //   e.preventDefault();
  //   body.classList.toggle("menu-open");
  // });

  // menuClose.addEventListener("click", (e) => {
  //   e.preventDefault();
  //   body.classList.remove("menu-open");
  // });

  // document.addEventListener("keyup", function (event) {
  //   if (event.key === "Escape") {
  //     body.classList.remove("menu-open");
  //   }
  // });

  document.addEventListener("scroll", () => {
    const scrolled = document.scrollingElement.scrollTop;
    const position = body.offsetTop;
    const header = document.querySelector(".site-header");

    if (scrolled > position + header.offsetHeight) {
      body.classList.add("scrolled");
    } else {
      body.classList.remove("scrolled");
    }
  });
}
