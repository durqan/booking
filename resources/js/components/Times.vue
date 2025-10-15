<script>
export default {
    props: [
        'selectedService'
    ],
    data() {
        return {
            startTime: new Date(), // начальное время
            endTime: new Date(),   // конечное время
            interval: null,
            isActive: false
        }
    },
    computed: {
        timeIntervals() {
            const intervals = [];

            // Устанавливаем начальное время на 10:00 текущего дня
            const start = new Date();
            start.setHours(10, 0, 0, 0);

            // Устанавливаем конечное время на 20:00 текущего дня
            const end = new Date();
            end.setHours(20, 0, 0, 0);

            let currentTime = start;

            // Генерируем интервалы пока не достигнем конечного времени
            while (currentTime <= end) {
                let className = 'not_busy';
                for (let time of this.selectedService.timesObj) {
                    if (time === this.formatTime(new Date(currentTime)))
                        className = 'busy';
                }
                intervals.push({'time': new Date(currentTime), 'className': className});
                currentTime = new Date(currentTime.getTime() + 30 * 60 * 1000);
            }

            return intervals;
        }
    },
    methods: {
        formatTime(date) {
            return date.toLocaleString('ru-RU', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        toggleActive(index, className,selectedTime) {
            if(className != 'busy'){
                this.isActive = this.isActive === index ? null : index;
                this.selectedService.time = selectedTime;
            }
        }
    }
}
</script>

<template>
    <div class="time-wrapper">
        <div class="times" v-for="(timeObj, index) in timeIntervals"
             :key="index"
             @click="toggleActive(index, timeObj.className, formatTime(timeObj.time))"
             :class="`${timeObj.className} ${isActive === index ? 'clicked' : ''}`">
            {{ formatTime(timeObj.time) }}
        </div>
    </div>
</template>

<style scoped>
.time-wrapper {
    column-count: 3;
}

.times {
    padding: 10px 10px 10px 10px;
    border: 1px solid rgb(203, 213, 225);
    border-radius: 0.5rem;
    margin: 0 20px 5px;
    cursor: pointer;
}

.not_busy:not(.clicked):hover {
    background-color: #acffac;
    color: white;
}

.clicked {
    background-color: #29aa29;
}

.busy {
    background-color: darkred;
    color: white;
    cursor: not-allowed!important;
}
</style>
