// dashboard.js

// Chart.js Configuration
const chartColors = {
    purple: "rgb(147, 51, 234)",
    pink: "rgb(236, 72, 153)",
    blue: "rgb(59, 130, 246)",
    green: "rgb(34, 197, 94)",
    orange: "rgb(249, 115, 22)",
    red: "rgb(239, 68, 68)",
};

function renderDashboardCharts(chartData) {
    // Mood Trend Chart (Line)
    const moodTrendCtx = document.getElementById("moodTrendChart");
    if (moodTrendCtx) {
        const moodTrendData = chartData["mood_trend"] || {};
        new Chart(moodTrendCtx, {
            type: "line",
            data: {
                labels: moodTrendData.labels || [
                    "Mon",
                    "Tue",
                    "Wed",
                    "Thu",
                    "Fri",
                    "Sat",
                    "Sun",
                ],
                datasets: [
                    {
                        label: "Mood Score",
                        data: moodTrendData.data || [
                            65, 70, 68, 75, 72, 80, 78,
                        ],
                        borderColor: chartColors.purple,
                        backgroundColor: "rgba(147, 51, 234, 0.1)",
                        tension: 0.4,
                        fill: true,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        pointBackgroundColor: chartColors.purple,
                        pointBorderColor: "#fff",
                        pointBorderWidth: 2,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                        padding: 12,
                        cornerRadius: 8,
                    },
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { stepSize: 25 } },
                },
            },
        });
    }

    // Mood Distribution Chart (Doughnut)
    const moodDistCtx = document.getElementById("moodDistributionChart");
    if (moodDistCtx) {
        const moodDistData = chartData["mood_distribution"] || {};
        new Chart(moodDistCtx, {
            type: "doughnut",
            data: {
                labels: moodDistData.labels || [
                    "Senang",
                    "Sedih",
                    "Cemas",
                    "Lelah",
                    "Tenang",
                ],
                datasets: [
                    {
                        data: moodDistData.data || [30, 15, 20, 10, 25],
                        backgroundColor: [
                            chartColors.green,
                            chartColors.blue,
                            chartColors.orange,
                            chartColors.red,
                            chartColors.purple,
                        ],
                        borderWidth: 2,
                        borderColor: "#fff",
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: "bottom",
                        labels: { padding: 15, usePointStyle: true },
                    },
                },
            },
        });
    }

    // Activity Chart (Bar)
    const activityCtx = document.getElementById("activityChart");
    if (activityCtx) {
        const activityData = chartData["activity"] || {};
        new Chart(activityCtx, {
            type: "bar",
            data: {
                labels:
                    activityData.labels ||
                    Array.from({ length: 30 }, (_, i) => i + 1),
                datasets: [
                    {
                        label: "Entries",
                        data:
                            activityData.data ||
                            Array.from({ length: 30 }, () =>
                                Math.floor(Math.random() * 5)
                            ),
                        backgroundColor: chartColors.purple,
                        borderRadius: 6,
                        barThickness: 12,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            },
        });
    }
}
