function setTableHeight() {
    console.log("setTable");
    const formBox  = document.querySelector('.createData');
    const tableBox = document.querySelector('.showTable');
    if (formBox && tableBox) {
        const h = formBox.getBoundingClientRect().height;
        tableBox.style.height   = h + 'px';
        tableBox.style.overflowY = 'auto';
    }
    }

document.addEventListener('DOMContentLoaded', () => {
    setTableHeight();            // sekali saat load
    window.addEventListener('resize', setTableHeight); // sinkron saat resize
});
