function startTimer(totalSeconds, formId = "examForm") {
    let time = Math.max(0, parseInt(totalSeconds, 10) || 0);
    const timerBox = document.getElementById("timer");
    const form = document.getElementById(formId);

    if (!timerBox || !form) {
        return;
    }

    function render() {
        const min = Math.floor(time / 60);
        const sec = time % 60;
        timerBox.textContent = `${String(min).padStart(2, "0")}:${String(sec).padStart(2, "0")}`;
        timerBox.classList.toggle("timer-warning", time <= 300 && time > 60);
        timerBox.classList.toggle("timer-danger", time <= 60);
    }

    function submitExpiredExam() {
        const autoSubmit = form.querySelector('input[name="auto_submit"]');
        if (autoSubmit) {
            autoSubmit.value = "1";
        }

        form.querySelectorAll("[required]").forEach((field) => {
            if (field.type === "radio" || field.type === "checkbox") {
                field.required = false;
            }
        });

        form.submit();
    }

    render();

    if (time <= 0) {
        submitExpiredExam();
        return;
    }

    const interval = setInterval(() => {
        time -= 1;
        render();

        if (time <= 0) {
            clearInterval(interval);
            submitExpiredExam();
        }
    }, 1000);
}
