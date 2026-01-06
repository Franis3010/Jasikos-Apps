import { gsap } from "gsap";

const app = document.getElementById("app");
app.classList.add("dark");

window.addEventListener("resize", updateMargin);
window.addEventListener("DOMContentLoaded", updateMargin);

function updateMargin() {
    const parent = document.querySelector("#hs-basic-heading-two");
    const firstChild = parent.querySelector(":first-child");

    if (window.innerWidth >= 768) {
        const parentHeight = parent.clientHeight;
        const childHeight = firstChild.clientHeight;
        const newMarginTop = parentHeight - childHeight;
        firstChild.style.marginTop = `${newMarginTop}px`;
    } else {
        firstChild.style.marginTop = "0px";
    }
}

document.querySelectorAll(".services a").forEach((link) => {
    link.addEventListener("click", (event) => {
        event.preventDefault();
        const service = event.target.dataset.service;
        const workItems = document.querySelectorAll(".work-item");
        const serviceTag = document.querySelector(".service-tag");
        const all = document.querySelector(".all");
        const tag = document.querySelector(".tag");

        if (service) {
            all.classList.add("hidden");
            tag.classList.remove("hidden");
            let total = 0;

            workItems.forEach((item) => {
                const itemServices = item.dataset.service
                    .split(",")
                    .map((s) => s.trim());

                if (service === undefined || itemServices.includes(service)) {
                    total += 1;
                }
            });

            serviceTag.innerHTML = `${service} (${total})`;
        } else {
            all.classList.remove("hidden");
            tag.classList.add("hidden");
        }

        workItems.forEach((item) => {
            const itemServices = item.dataset.service
                .split(",")
                .map((s) => s.trim());

            if (service === undefined || itemServices.includes(service)) {
                gsap.timeline()
                    .set(item, {
                        opacity: 0,
                        display: "block",
                    })
                    .to(item, {
                        duration: 0.5,
                        opacity: 1,
                        ease: "power2.inOut",
                    });
            } else {
                item.style.display = "none";
            }
        });
    });
});
