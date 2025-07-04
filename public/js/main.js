console.log("apa")
const fiturElements = document.querySelectorAll('.fitur-scroll');

function checkScrollFitur() {
    console.log("cek");
    fiturElements.forEach(el => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight) {
            el.classList.add('visible');
        }
    });
}

window.addEventListener('scroll', checkScrollFitur);
window.addEventListener('load', checkScrollFitur);

const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

function setActiveMenu() {
    let currentPath = window.location.pathname;
    let pathSegments = currentPath.split('/').filter(Boolean);

    // Ambil link ke dua
    let currentFile = pathSegments[1] || '';

    console.log('Current File:', currentFile);

    allSideMenu.forEach(item => {
        const li = item.parentElement;
        const itemHref = item.getAttribute('href');

        li.classList.remove('active');

        if (itemHref && currentFile === itemHref.split('/').pop()) {
            console.log("cek");
            li.classList.add('active');
        }
    });
}

window.addEventListener('load', function () {
    setActiveMenu();
});

const menuBar = document.querySelector('#content nav .bx.bx-menu');
const filterMenu = document.querySelector('.bx.bx-filter');
const boxFilter = document.querySelector('.boxFilter');
const searchMenu = document.querySelector('.bx.bx-search');
const searchForm = document.querySelector('#searchForm');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

filterMenu.addEventListener('click', function () {
	boxFilter.classList.toggle('active');
})

searchMenu.addEventListener('click', function () {
    console.log('apa');
	searchForm.classList.toggle('active');
})
