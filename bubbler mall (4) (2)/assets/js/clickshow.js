var galleryWrapper = document.getElementById("gallery-wrapper");
let pic = "service-01.png";
const whitePanel = galleryWrapper.querySelectorAll(".white-panel"),
    paneldetail = document.querySelector(".detail.hide"),
    showDetail = document.querySelector(".detail");


window.onload = () => {
    whitePanel[0].onclick = () => {
        for (var j = 0; j < whitePanel.length; j++) {
            whitePanel[j].classList.add("hide");
        }
        paneldetail.classList.remove("hide");

        pic = "service-01.png";
        str = '<img src="assets/images/' + pic + '" class="thumb">';
        showDetail.insertAdjacentHTML("afterBegin", str);
    }
    whitePanel[1].onclick = () => {
        for (var j = 0; j < whitePanel.length; j++) {
            whitePanel[j].classList.add("hide");
        }
        paneldetail.classList.remove("hide");

        pic = "service-02.png";
        str = '<img src="assets/images/' + pic + '" class="thumb">';
        showDetail.insertAdjacentHTML("afterBegin", str);
    }
    whitePanel[2].onclick = () => {
        for (var j = 0; j < whitePanel.length; j++) {
            whitePanel[j].classList.add("hide");
        }
        paneldetail.classList.remove("hide");

        pic = "service-03.png";
        str = '<img src="assets/images/' + pic + '" class="thumb">';
        console.log(str);
        showDetail.insertAdjacentHTML("afterBegin", str);
    }
}

//click
class CreatePattern {
    constructor() {
        this.color = presetColor.palette[mFmR(presetColor.palette.length)]
        this.initialStyles = document.createElement('i')
    }

    //添加class
    growUp(pattern, x, y) {
        this.initialStyles.classList.add(pattern)
        this.initialStyles.style.cssText = `background-color:${this.color};left:${x}px;top:${y}px;z-index:999`
        abc.append(this.initialStyles)
    }

    //随机散开
    dynamic() {
        let sc = 1,
            x = 0,
            y = 0

        function trans(a, b, c) {
            if (b) {
                a -= c
            } else {
                a += c
            }
            return a
        }
        //骰子
        let dice = function(a, b) {
            return a < 6 && b < 6 ? dice(mFmR(20), mFmR(20)) : [a, b]
        }
        let dd = dice(mFmR(20), mFmR(20));

        let polePositiveNegative = [mFmR(2), mFmR(2)]

        let animating = setInterval(() => {
            //sc归零动画结束
            if (sc <= 0) {
                clearInterval(animating)
                this.initialStyles.remove()
            } else {
                sc -= 0.1
                x = trans(x, polePositiveNegative[0], dd[0]);
                y = trans(y, polePositiveNegative[1], dd[1]);
                this.initialStyles.style.transform = `translate(${x}px,${y}px) scale(0)`
            }
        }, 99);
    }
}

function mFmR(value) {
    return Math.floor(Math.random() * value)
}

//调色盘
const presetColor = {
    palette: ["#fff", "#ccffff", "#99ffff", "#66ffff"]
}

function produceStyle(pattern, x, y) {
    let produce = new CreatePattern()
    produce.growUp(pattern, x, y)
    produce.dynamic()
}

let abc = document.querySelector('.click')
document.addEventListener('click', function(e) {
    for (let i = 0; i < 10; i++) {
        produceStyle('bubble', e.pageX, e.pageY)
    }
})