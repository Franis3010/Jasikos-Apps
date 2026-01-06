import { gsap } from "gsap";

const app = document.getElementById("app");
app.classList.add("dark");

const loadMoreBtn = document.getElementById("loadMore");
const content = document.querySelector(".content");
const gradient = document.querySelector(".gradient-overlay");
let isExpanded = false;

loadMoreBtn.addEventListener("click", function () {
    gsap.timeline()
        .to(content, {
            height: isExpanded ? "200px" : "auto",
            duration: 0.5,
        })
        .to(
            gradient,
            {
                opacity: isExpanded ? 1 : 0,
                duration: 0.5,
            },
            "<"
        );

    isExpanded = !isExpanded;
    loadMoreBtn.querySelector("span").textContent = isExpanded
        ? "Read Less"
        : "Read More";
});
