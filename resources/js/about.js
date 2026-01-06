import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const stays = document.querySelectorAll(".stay");

const initTriggers = () => {
    stays.forEach((stay) => {
        const content = stay.querySelector(".stay-content");
        ScrollTrigger.create({
            trigger: stay,
            start: "top 84",
            end: () => `bottom ${content.offsetHeight + 84}`,
            pin: content,
            invalidateOnRefresh: true,
        });
    });
};

const updateHeight = (stay) => {
    const siblingDiv = stay.nextElementSibling.querySelector("div");
    if (siblingDiv) {
        if (window.innerWidth >= 768) {
            stay.style.height = `${siblingDiv.offsetHeight}px`;
        } else {
            stay.style.height = "";
        }
        ScrollTrigger.refresh();
    }
};

const updateAllHeights = () => {
    stays.forEach(updateHeight);
};

const resetHeight = () => {
    stays.forEach((stay) => (stay.style.height = ""));
};

const handleMediaChange = (e) => {
    if (e.matches) {
        initTriggers();
        updateAllHeights();
        const observer = new ResizeObserver(updateAllHeights);
        stays.forEach((stay) => {
            const siblingDiv = stay.nextElementSibling.querySelector("div");
            if (siblingDiv) observer.observe(siblingDiv);
        });
    } else {
        ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
        resetHeight();
    }
};

const mediaQuery = window.matchMedia("(min-width: 0px)");
handleMediaChange(mediaQuery);
mediaQuery.addEventListener("change", handleMediaChange);
