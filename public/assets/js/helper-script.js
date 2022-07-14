var modal = document.querySelector('.report-modal');
document.querySelectorAll('.crd').forEach((arg, index) => {
    arg.onclick = function () {
        modal.style.display = 'block';
        if (index == 0) {
            document.querySelector(".video").style.display = "block";
            document.querySelector(".camera").style.display = "none";
        }
        else if (index == 1) {
            document.querySelector(".video").style.display = "none";
            document.querySelector(".camera").style.display = "block";
        }
    }
})
document.querySelector(".video-btn").addEventListener('click', function () {
    if (this.id == 'start') {
        $('[data-toggle=popover]').popover();
        this.color = 'yellow'
        this.backgroundColor = 'green';
        // this.border = '2px solid red';
    }

})
document.querySelector('.close-modal').onclick = () => modal.style.display = 'none';
