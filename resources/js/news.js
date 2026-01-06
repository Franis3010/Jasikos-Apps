import { gsap } from "gsap";

document.querySelectorAll(".category a").forEach((link) => {
    link.addEventListener("click", (event) => {
        event.preventDefault();
        const category = event.target.dataset.category;
        const newsItems = document.querySelectorAll(".news-item");
        newsItems.forEach((item) => {
            if (category === "" || item.dataset.category === category) {
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
        document.querySelectorAll(".category a").forEach((link) => {
            link.classList.remove("text-black");
        });
        event.target.classList.add("text-black");
    });
});
