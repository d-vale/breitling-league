import { ref } from "vue";

export const checkDarkMode = () => {
    // Check saved preference
    const savedPreference = localStorage.getItem("darkMode");
    if (savedPreference) {
        return savedPreference === "enabled";
    }

    // Check system preference
    return (
        window.matchMedia &&
        window.matchMedia("(prefers-color-scheme: dark)").matches
    );
};

export const applyTheme = () => {
    // Apply dark mode class to document
    if (isDarkMode.value) {
        document.documentElement.classList.add("dark-mode");
        document.documentElement.setAttribute("data-theme", "dark");
    } else {
        document.documentElement.classList.remove("dark-mode");
        document.documentElement.setAttribute("data-theme", "light");
    }
};

export const isDarkMode = ref(false);
