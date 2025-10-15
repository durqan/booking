<script>
import RadioButton from 'primevue/radiobutton';
import RadioButtonGroup from 'primevue/radiobuttongroup';
import Button from 'primevue/button';

export default {
    components: {RadioButton, RadioButtonGroup, Button},
    props: [
        'service',
        'selectedService'
    ],
    data() {
        return {
            isSelected: false,
            ingredient: ''
        }
    }
}
</script>
<template>
    <div class="service-card">
        <div class="card-header">
            <h3>{{ service.name }}</h3>
        </div>
        <div style="display: flex; justify-content: space-between">
            <div>
                <div class="card-content" v-for="kind_of in service.prices">
                    <div style="display: flex">
                        <div class="duration-selector">
                            <div class="price">{{ kind_of.price }} ₽</div>
                            <div class="duration-label">Длительность: {{ kind_of.name }} мин</div>
                        </div>
                        <div style="align-self: flex-end">
                            <RadioButton v-model="selectedService.price_id" :inputId="kind_of.id" name="pizza"
                                         :value="kind_of.id" @click="() => {selectedService.id = null; selectedService.date = null; selectedService.timesObj = null; selectedService.time = null;}"/>
                        </div>
                    </div>
                </div>
            </div>
            <Button class="btn btn-success" @click="selectedService.id = service.id" style="align-self: flex-end">
                Выбрать
            </Button>
        </div>
    </div>
</template>
<style scoped>
.service-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin: 15px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.duration-selector {
    display: flex;
    flex-direction: column;
    margin-top: 15px;
}

.duration-label {
    width: 200px;
    font-size: 14px;
    color: #777;
}

.duration-option input {
    accent-color: #2196F3;
}
</style>
