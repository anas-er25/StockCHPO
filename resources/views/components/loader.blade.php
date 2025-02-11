<div class="loader" id="loader-myModal">
    <div class="word">
        <span class="letter b">B</span>
        <span class="letter u">U</span>
        <span class="letter r">R</span>
        <span class="letter e">E</span>
        <span class="letter a1">A</span>
        <span class="letter u2">U</span>
        &nbsp;
        <span class="letter m">M</span>
        <span class="letter a2">A</span>
        <span class="letter t">T</span>
        <span class="letter e2">É</span>
        <span class="letter r2">R</span>
        <span class="letter i">I</span>
        <span class="letter e3">E</span>
        <span class="letter l">L</span>
    </div>
</div>

<style>
    /* Loader fullscreen styles */
    .loader {
        display: flex;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.9);
        z-index: 9999;
    }

    .word {
        font-size: 2em;
        font-weight: bold;
        text-transform: uppercase;
    }

    .letter {
        display: inline-block;
        animation: bounce 1.5s infinite, color-change 4s infinite;
    }

    /* Bounce animation */
    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-20px);
        }
    }

    /* Color change animation */
    @keyframes color-change {
        0% {
            color: #FF5733; /* Orange */
        }
        25% {
            color: #33FF57; /* Green */
        }
        50% {
            color: #3357FF; /* Blue */
        }
        75% {
            color: #F3FF33; /* Yellow */
        }
        100% {
            color: #FF33F3; /* Pink */
        }
    }

    /* Animation delays for each letter */
    .b { animation-delay: 0.1s; }
    .u { animation-delay: 0.2s; }
    .r { animation-delay: 0.3s; }
    .e { animation-delay: 0.4s; }
    .a1 { animation-delay: 0.5s; }
    .u2 { animation-delay: 0.6s; }
    .m { animation-delay: 0.7s; }
    .a2 { animation-delay: 0.8s; }
    .t { animation-delay: 0.9s; }
    .e2 { animation-delay: 1.0s; }
    .r2 { animation-delay: 1.1s; }
    .i { animation-delay: 1.2s; }
    .e3 { animation-delay: 1.3s; }
    .l { animation-delay: 1.4s; }
</style>
