// diaryCreate.js - Handle diary analysis display with loading animation
// Pure JavaScript - no inline data needed

document.addEventListener("DOMContentLoaded", function () {
    console.log("=== Diary Create JS Loaded ===");

    // Get analysis container
    const analysisContainer = document.getElementById("analysisContainer");

    // Check if analysis exists on page
    if (!analysisContainer) {
        console.log("No analysis container found - skipping");
        return;
    }

    // Get data from data attributes
    const reflection = analysisContainer.dataset.reflection;
    const habit = analysisContainer.dataset.habit;

    if (!reflection || !habit) {
        console.error("Analysis data missing from data attributes");
        return;
    }

    console.log("Analysis Data Loaded:", { reflection, habit });

    // Get DOM elements
    const loadingSection = document.getElementById("loadingSection");
    const analysisSection = document.getElementById("analysisSection");
    const reflectionEl = document.getElementById("aiReflection");
    const habitEl = document.getElementById("aiHabit");

    // Validate elements exist
    if (!loadingSection || !analysisSection || !reflectionEl || !habitEl) {
        console.error("Required DOM elements not found");
        return;
    }

    // Show loading for 10 seconds
    const loadingDuration = 10000; // Change to 3000 for testing

    setTimeout(() => {
        console.log("Loading complete, displaying analysis...");

        // Hide loading
        loadingSection.classList.add("hidden");

        // Show analysis section
        analysisSection.classList.remove("hidden");

        // Display reflection with fade-in animation
        setTimeout(() => {
            reflectionEl.textContent = reflection;
            reflectionEl.classList.remove("opacity-0");
            reflectionEl.classList.add("opacity-100");
            console.log("Reflection displayed");
        }, 200);

        // Display habit with fade-in animation (slightly delayed)
        setTimeout(() => {
            habitEl.textContent = habit;
            habitEl.classList.remove("opacity-0");
            habitEl.classList.add("opacity-100");
            console.log("Habit displayed");
        }, 600);
    }, loadingDuration);
});
