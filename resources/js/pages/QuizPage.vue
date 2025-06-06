<script setup>
import { onMounted, ref, watch, onUnmounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";

const route = useRoute();
const router = useRouter();
const quiz = ref(null);
const loading = ref(false);
const error = ref(null);
const timer = ref(null);
const startTime = ref(null);
const elapsedTime = ref(0);
const currentQuestionIndex = ref(0);
const selectedChoice = ref(null);
const questionStartTime = ref(null);
const submitting = ref(false);
const showResult = ref(false);
const lastResult = ref(null);
const quizScore = ref(0);
const quizFinished = ref(false);
const totalPoints = ref(0);
const correctAnswers = ref(0);

const numberOfQuestions = computed(() => {
    if (!quiz.value) return 0;
    return quiz.value.total_questions || quiz.value.questions?.length || 0;
});

const currentQuestion = computed(() => {
    if (
        !quiz.value?.questions ||
        currentQuestionIndex.value >= quiz.value.questions.length
    ) {
        return null;
    }
    return quiz.value.questions[currentQuestionIndex.value];
});

const progress = computed(() => {
    if (numberOfQuestions.value === 0) return 0;
    return ((currentQuestionIndex.value + 1) / numberOfQuestions.value) * 100;
});

const quizType = computed(() => {
    return route.path === "/quiz/arena" ? "Novelties Arena" : "Main Quest";
});

const fetchRandomQuiz = async () => {
    try {
        loading.value = true;
        error.value = null;
        
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const response = await fetch("/api/v1/quiz/", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const result = await response.json();
        
        if (result.success && result.data) {
            quiz.value = result.data;
            startTimer();
            startQuestionTimer();
        } else {
            throw new Error("Invalid response format");
        }
    } catch (err) {
        error.value = err.message;
        console.error("Error fetching quiz:", err);
    } finally {
        loading.value = false;
    }
};

const fetchArenaQuiz = async () => {
    try {
        loading.value = true;
        error.value = null;
        
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const response = await fetch("/api/v1/quiz/arena", {
            method: "GET",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const result = await response.json();
        
        if (result.success && result.data) {
            quiz.value = result.data;
            startTimer();
            startQuestionTimer();
        } else {
            throw new Error("Invalid response format");
        }
    } catch (err) {
        error.value = err.message;
        console.error("Error fetching arena quiz:", err);
    } finally {
        loading.value = false;
    }
};

const startTimer = () => {
    if (timer.value) {
        clearInterval(timer.value);
    }

    startTime.value = performance.now();
    elapsedTime.value = 0;

    timer.value = setInterval(() => {
        elapsedTime.value = performance.now() - startTime.value;
    }, 10);
};

const stopTimer = () => {
    if (timer.value) {
        clearInterval(timer.value);
        timer.value = null;
    }
};

const startQuestionTimer = () => {
    questionStartTime.value = new Date().toISOString();
};

const selectChoice = (choiceId) => {
    selectedChoice.value = choiceId;
    console.log("Choice selected", choiceId);
};

const submitAnswer = async () => {
    if (!selectedChoice.value || !currentQuestion.value || submitting.value)
        return;

    submitting.value = true;
    const questionEndTime = new Date().toISOString();

    try {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        const response = await fetch("/api/v1/quiz/response", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest",
                Accept: "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                question_id: currentQuestion.value.question_id,
                choice_id: selectedChoice.value,
                quiz_id: quiz.value.quiz_id,
                time_question_start: questionStartTime.value,
                time_question_end: questionEndTime,
                quiz_type: quizType.value,
            }),
        });

        if (!response.ok) {
            throw new Error("Failed to submit answer");
        }

        const result = await response.json();
        
        if (result.success) {
            // Stocker le résultat pour l'affichage
            lastResult.value = result.data;
            showResult.value = true;
            
            // Compter les points et réponses correctes
            totalPoints.value += result.data.points_earned;
            if (result.data.is_correct) {
                correctAnswers.value++;
            }
        } else {
            throw new Error(result.message || "Failed to submit answer");
        }
    } catch (err) {
        error.value = err.message;
        console.error("Error submitting answer:", err);
    } finally {
        submitting.value = false;
    }
};

const nextQuestion = () => {
    showResult.value = false;
    
    // Passer à la question suivante
    if (currentQuestionIndex.value < numberOfQuestions.value - 1) {
        currentQuestionIndex.value++;
        selectedChoice.value = null;
        startQuestionTimer();
    } else {
        // Quiz terminé
        stopTimer();
        quizFinished.value = true;
        
        // Calculer le score en pourcentage
        quizScore.value = Math.round((correctAnswers.value / numberOfQuestions.value) * 100);
    }
};

const startNewQuiz = () => {
    quizFinished.value = false;
    quizScore.value = 0;
    totalPoints.value = 0;
    correctAnswers.value = 0;
    loadQuiz();
};

const loadQuiz = () => {
    stopTimer();
    currentQuestionIndex.value = 0;
    selectedChoice.value = null;
    showResult.value = false;
    lastResult.value = null;
    quizFinished.value = false;
    quizScore.value = 0;
    totalPoints.value = 0;
    correctAnswers.value = 0;

    if (route.path === "/quiz/arena") {
        fetchArenaQuiz();
    } else {
        fetchRandomQuiz();
    }
};

const formatTime = (milliseconds) => {
    const totalMs = Math.floor(milliseconds);
    const minutes = Math.floor(totalMs / 60000);
    const seconds = Math.floor((totalMs % 60000) / 1000);
    return `${minutes.toString().padStart(2, "0")}min${seconds
        .toString()
        .padStart(2, "0")}s`;
};

const goHome = () => {
    router.push('/');
};

watch(
    () => route.path,
    () => {
        if (route.path === "/quiz" || route.path === "/quiz/arena") {
            loadQuiz();
        }
    }
);

onMounted(() => {
    loadQuiz();
});

onUnmounted(() => {
    stopTimer();
});
</script>

<template>
    <div class="quiz-container">
        <!-- État de chargement -->
        <div v-if="loading" class="loading">Chargement du quiz...</div>

        <!-- État d'erreur -->
        <div v-if="error && !loading" class="error">
            <p>Erreur : {{ error }}</p>
            <button @click="loadQuiz" class="retry-button">Réessayer</button>
        </div>

        <!-- Affichage du résultat de la question -->
        <div v-if="showResult && lastResult && !loading && !error" class="result-overlay">
            <div class="result-card">
                <div class="result-icon" :class="{ correct: lastResult.is_correct, incorrect: !lastResult.is_correct }">
                    <svg v-if="lastResult.is_correct" width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <svg v-else width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h3 class="result-title">
                    {{ lastResult.is_correct ? 'Correct !' : 'Incorrect' }}
                </h3>
                <p class="result-points">
                    +{{ lastResult.points_earned }} points
                </p>
                <div v-if="!lastResult.is_correct" class="correct-answer">
                    <p>Bonne réponse :</p>
                    <p class="correct-text">{{ lastResult.correct_choice.texte }}</p>
                </div>
                <div class="result-stats">
                    <p>Temps de réponse : {{ lastResult.response_time_seconds }}s</p>
                    <p>Total points : {{ lastResult.user_total_points.toLocaleString() }}</p>
                </div>
                <button @click="nextQuestion" class="next-button">
                    {{ currentQuestionIndex < numberOfQuestions - 1 ? 'Next Question' : 'Finish Quiz' }}
                </button>
            </div>
        </div>

        <!-- Quiz terminé avec score -->
        <div v-if="quizFinished && !loading && !error && !showResult" class="quiz-finished">
            <div class="score-circle-container">
                <svg class="score-circle" width="200" height="200" viewBox="0 0 200 200">
                    <!-- Cercle de fond -->
                    <circle
                        cx="100"
                        cy="100"
                        r="80"
                        fill="none"
                        stroke="#333"
                        stroke-width="8"
                    />
                    <!-- Cercle de progression -->
                    <circle
                        cx="100"
                        cy="100"
                        r="80"
                        fill="none"
                        stroke="#22c55e"
                        stroke-width="8"
                        stroke-linecap="round"
                        :stroke-dasharray="2 * Math.PI * 80"
                        :stroke-dashoffset="2 * Math.PI * 80 * (1 - quizScore / 100)"
                        transform="rotate(-90 100 100)"
                        class="progress-circle"
                    />
                </svg>
                <div class="score-text">
                    <div class="score-percentage">{{ quizScore }}%</div>
                    <div class="score-label">Score</div>
                </div>
            </div>
            
            <div class="points-display">
                <span class="points-earned">{{ totalPoints.toLocaleString() }} points earned</span>
            </div>
            
            <div class="finish-actions">
                <button @click="goHome" class="btn-secondary">Return Home</button>
                <button @click="startNewQuiz" class="btn-primary">Next Quiz</button>
            </div>
        </div>

        <!-- Quiz en cours -->
        <div v-if="quiz && currentQuestion && !loading && !error && !showResult && !quizFinished" class="quiz-content">
            <!-- Header avec question actuelle et total -->
            <div class="quiz-header">
                <div class="question-badge">
                    Question {{ currentQuestionIndex + 1 }}
                </div>
                <div class="timer-display">
                    {{ formatTime(elapsedTime) }}
                </div>
                <div class="question-counter">
                    {{ currentQuestionIndex + 1 }} of {{ numberOfQuestions }}
                </div>
            </div>

            <!-- Progress bar -->
            <div class="progress-container">
                <div
                    class="progress-bar"
                    :style="{ width: progress + '%' }"
                ></div>
            </div>

            <!-- Question -->
            <div class="question-section">
                <h3 class="question-number">
                    Question #{{ currentQuestionIndex + 1 }}
                </h3>
                <h2 class="question-title">{{ currentQuestion.texte }}</h2>
            </div>

            <!-- Choices -->
            <div class="choices-section">
                <h3 class="choose-text">Choose one</h3>
                <div class="choices-list">
                    <div
                        v-for="choice in currentQuestion.choices"
                        :key="choice.choice_id"
                        :class="`choice-item ${
                            selectedChoice === choice.choice_id
                                ? 'selected'
                                : ''
                        }`"
                        @click="selectChoice(choice.choice_id)"
                    >
                        {{ choice.texte }}
                    </div>
                </div>
            </div>

            <!-- Submit button -->
            <button 
                class="submit-button" 
                @click="submitAnswer"
                :disabled="!selectedChoice || submitting"
            >
                {{ submitting ? "Submitting..." : "Submit answer" }}
            </button>
        </div>

        <!-- Aucun quiz disponible -->
        <div v-if="!quiz && !loading && !error && !showResult && !quizFinished" class="no-quiz">
            <p>Aucun quiz disponible</p>
            <button @click="loadQuiz" class="retry-button">Réessayer</button>
        </div>
    </div>
</template>

<style scoped>
.quiz-container {
    width: 100%;
    padding: 25px;
    margin: 0 auto;
    background-color: #000;
    color: white;
    min-height: 100vh;
}

.loading,
.error,
.no-quiz {
    text-align: center;
    padding: 2rem;
    border-radius: 8px;
    margin: 1rem 0;
}

.loading {
    color: #ffffff;
}

.error {
    color: #dc2626;
}

.no-quiz {
    color: #6b7280;
}

.retry-button {
    background-color: #ffc629;
    color: black;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 1rem;
}

.result-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.result-card {
    background-color: #222;
    padding: 2rem;
    border-radius: 20px;
    text-align: center;
    max-width: 300px;
    width: 90%;
}

.result-icon {
    margin: 0 auto 1rem;
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.result-icon.correct {
    background-color: #22c55e;
    color: white;
}

.result-icon.incorrect {
    background-color: #ef4444;
    color: white;
}

.result-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.result-points {
    font-size: 1.2rem;
    color: #ffc629;
    font-weight: bold;
    margin-bottom: 1rem;
}

.correct-answer {
    background-color: #333;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.correct-text {
    color: #22c55e;
    font-weight: bold;
}

.result-stats {
    font-size: 0.9rem;
    color: #ccc;
    margin-bottom: 1.5rem;
}

.next-button {
    background-color: #ffc629;
    color: black;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
}

.next-button:hover {
    background-color: #ffb500;
}

.quiz-content {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.quiz-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.question-badge {
    background-color: #ffc629;
    color: black;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
}

.timer-display {
    font-family: monospace;
    font-size: 1.1rem;
    font-weight: bold;
}

.question-counter {
    background-color: #333;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

.progress-container {
    width: 100%;
    height: 6px;
    background-color: #333;
    border-radius: 3px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background-color: #ffc629;
    transition: width 0.3s ease;
}

.question-section {
    text-align: center;
    background-color: #222;
    padding: 2rem;
    border-radius: 12px;
}

.question-number {
    color: #ffc629;
    font-size: 1rem;
    margin-bottom: 1rem;
}

.question-title {
    font-size: 1.8rem;
    font-weight: bold;
    line-height: 1.3;
    margin: 0;
}

.choices-section {
    margin: 2rem 0;
}

.choose-text {
    text-align: center;
    font-size: 1.2rem;
    margin-bottom: 1.5rem;
    color: #ccc;
}

.choices-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.choice-item {
    background-color: #333;
    padding: 1rem 1.5rem;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.2s ease;
    border: 2px solid transparent;
}

.choice-item:hover {
    background-color: #444;
}

.choice-item.selected {
    border-color: #ffc629;
    background-color: #444;
}

.submit-button {
    background-color: #ffc629;
    color: black;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 2rem;
}

.submit-button:hover:not(:disabled) {
    background-color: #ffb500;
}

.submit-button:disabled {
    background-color: #666;
    color: #999;
    cursor: not-allowed;
}

.quiz-completed {
    text-align: center;
    padding: 3rem 1rem;
}

.completion-icon {
    margin: 0 auto 2rem;
    width: 100px;
    height: 100px;
    background-color: #333;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.quiz-completed h2 {
    color: #ffc629;
    font-size: 2rem;
    margin-bottom: 1rem;
}

.completion-time {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    color: #ccc;
}

.home-button {
    background-color: #ffc629;
    color: black;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
}

.home-button:hover {
    background-color: #ffb500;
}

.quiz-finished {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 80vh;
    text-align: center;
    padding: 2rem;
}

.score-circle-container {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 2rem;
}

.score-circle {
    transform: rotate(-90deg);
}

.progress-circle {
    transition: stroke-dashoffset 1.5s ease-in-out;
}

.score-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.score-percentage {
    font-size: 3rem;
    font-weight: bold;
    color: #22c55e;
    line-height: 1;
}

.score-label {
    font-size: 1rem;
    color: #ccc;
    margin-top: 0.5rem;
}

.points-display {
    margin-bottom: 3rem;
}

.points-earned {
    font-size: 1.5rem;
    color: #ffc629;
    font-weight: 600;
}

.finish-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-primary {
    background-color: #ffc629;
    color: black;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background-color: #ffb500;
}

.btn-secondary {
    background-color: #333;
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 25px;
    font-size: 1.1rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background-color: #444;
}

@media (max-width: 768px) {
    .finish-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-primary, .btn-secondary {
        width: 100%;
    }
}
</style>