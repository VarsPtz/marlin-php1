var navbarFirstItem = document.querySelector(".navbar-nav_first_item"),
    submenu = document.querySelector(".submenu");
console.log(navbarFirstItem);
console.log(submenu);

navbarFirstItem.addEventListener("mouseover", () => {
    submenu.classList.toggle("item-hide");
});