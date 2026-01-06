import { gsap } from "gsap";

const carousel = document.getElementById("carousel");
const items = carousel.getElementsByClassName("hs-carousel-slide");

// Function to handle class change
function handleClassChange(mutationsList) {
    mutationsList.forEach((mutation) => {
        if (mutation.attributeName === "class") {
            const activeChild = carousel.querySelector(".active");
            if (activeChild === mutation.target) {
                const client = document.getElementById("client");
                const title = document.getElementById("title");
                const dataClient = activeChild.getAttribute("data-client");
                const dataTitle = activeChild.getAttribute("data-title");
                client.textContent = dataClient;
                title.textContent = dataTitle;
            }
        }
    });
}

// Create observer to detect attribute changes
const observer = new MutationObserver(handleClassChange);

// Observer configuration
const config = {
    attributes: true,
    attributeFilter: ["class"],
};

// Apply observer to each item in the carousel
Array.from(items).forEach((item) => {
    observer.observe(item, config);
});

// Marquee
const marquee = gsap.timeline({ repeat: -1 });

marquee.fromTo(
    ".marquee-first",
    { xPercent: 100 },
    { xPercent: 0, duration: 5, ease: "none" }
);
marquee.fromTo(
    ".marquee-second",
    { xPercent: 0 },
    { xPercent: -100, duration: 5, ease: "none" },
    "<"
);
