window.addEventListener("DOMContentLoaded", () => {
    const loader = document.getElementById("loader-myModal");
    loader.style.display = "flex";
    document.body.style.overflow = "hidden"; // Prevent scrolling while loading
});

window.addEventListener("load", () => {
    const loader = document.getElementById("loader-myModal");
    loader.style.opacity = "0";
    loader.style.transition = "opacity 0.3s ease-out";

    setTimeout(() => {
        loader.style.display = "none";
        document.body.style.overflow = "auto"; // Restore scrolling
    }, 300);
});
