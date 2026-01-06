import "preline";
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);
let mm = gsap.matchMedia();

const navbar = document.getElementById("navbar");
const navbarButton = document.getElementById("hs-navbar-example-collapse");
const backdrop = document.getElementById("backdrop");

gsap.set(".logo-long", { y: 2 });
gsap.set(".logo-short", { y: 100 });

ScrollTrigger.create({
    start: "top top",
    end: "bottom",
    toggleClass: { className: "scrolled", targets: "#navbar" },
    onEnter: () => {
        handleNavbarEnter();
    },
    onLeaveBack: () => {
        handleNavbarLeave();
    },
});

navbarButton.addEventListener("click", toggleNavbar);
backdrop.addEventListener("click", () => {
    navbarButton.click();
});

function handleNavbarEnter() {
    navbar.classList.add("navbar-scrolled");
    const tl = gsap.timeline();

    mm.add("(max-width: 768px)", () => {
        tl.to(
            "#navbar",
            {
                maxWidth: "375px",
                duration: 0.4,
                ease: "power2.out",
            },
            "<"
        );
    });

    mm.add("(min-width: 768px)", () => {
        tl.to(
            "#navbar",
            {
                maxWidth: "900px",
                duration: 0.4,
                ease: "power2.out",
            },
            "<"
        );
    });

    tl.to(".logo-long", { y: -20, duration: 0.4 }, "<")
        .to(".logo-short", { y: -17.9, duration: 0.4 }, "<")
        .to(
            "#navbar-parent",
            { paddingLeft: "48px", paddingRight: "48px" },
            "<"
        );
}

function handleNavbarLeave() {
    if (!navbarButton.classList.contains("open")) {
        navbar.classList.remove("navbar-scrolled");
    }

    const tl = gsap.timeline();

    tl.to(
        "#navbar",
        {
            maxWidth: "1536px",
            duration: 0.4,
            ease: "power2.in",
        },
        "<"
    )
        .to("#navbar-parent", { paddingLeft: "8px", paddingRight: "8px" }, "<")
        .to(".logo-long", { y: 2, duration: 0.4 }, "<")
        .to(".logo-short", { y: 20, duration: 0.4 }, "<");
}

function toggleNavbar() {
    if (navbarButton.classList.contains("open")) {
        if (!navbar.classList.contains("scrolled")) {
            navbar.classList.remove("navbar-scrolled");
        }
        gsap.to(backdrop, {
            duration: 0.5,
            css: { position: "absolute", opacity: 0 },
        });
        backdrop.classList.add("hidden");
    } else {
        navbar.classList.add("navbar-scrolled");
        gsap.from(backdrop, { css: { position: "absolute", opacity: 0 } });
        gsap.to(backdrop, {
            duration: 0.5,
            css: { position: "absolute", opacity: 1 },
        });
        backdrop.classList.remove("hidden");
    }
}
