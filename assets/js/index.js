const searchBtn = document.querySelector(".search-btn");
const navListItem = document.querySelector(".nav-bar-list-item");
const textField = document.querySelector(".text-field");
const submitBtn = document.querySelector(".submit-btn");
const iconClose = document.querySelector(".icon-close");
const btnShow = document.querySelector('.category-show');
const modal = document.querySelector('.js-modal');
const modalContainer = document.querySelector('.js-modal-container');
const modalClose = document.querySelector('.js-modal-close');

searchBtn.addEventListener("click", () => {
    navListItem.style.display = "none";
    textField.style.display = "block";
    iconClose.style.display = "block";
});

submitBtn.addEventListener("click", () => {
    navListItem.style.display = "block";
    textField.style.display = "none";
    iconClose.style.display = "none";
});

iconClose.addEventListener("click", () => {
    navListItem.style.display = "block";
    textField.style.display = "none";
    iconClose.style.display = "none";
});

window.onscroll = function () {
    if (document.documentElement.scrollTop > 200) {
        document.querySelector(".back-to-home").style.display = "block";
    } else {
        document.querySelector(".back-to-home").style.display = "none";
    }
};

// Hàm hiển thị modal Category ( thêm class open vào modal )
function showCategory() {
    modal.classList.add('open')
};

// Hàm gỡ bỏ modal Category ( gỡ class open của modal )
function hideCategory() {
    modal.classList.remove('open')
};

btnShow.addEventListener('click', showCategory);

// Nghe hành vi click vào button close
modalClose.addEventListener('click', hideCategory);
modal.addEventListener('click', hideCategory);
modalContainer.addEventListener('click', function (event) {
    event.stopPropagation();
});