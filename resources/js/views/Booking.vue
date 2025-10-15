<script>
import ServiceCard from "../components/ServiceCard.vue";
import Times from "../components/Times.vue";
import axios from "axios";
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import InputMask from 'primevue/inputmask';
import {Form} from '@primevue/forms';
import Message from 'primevue/message';

export default {
    components: {ServiceCard, Times, Dialog, Button, InputText, InputMask, Form, Message},
    props: {
        services: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            selectedService: {
                id: null,
                price_id: null,
                date: null,
                timesObj: null,
                time: null
            },
            visible: false,
            initialValues: {
                firstname: '',
                phone: ''
            }
        }
    },
    methods: {
        find_available_slots(date) {
            date = date.toLocaleString('ru-RU', {
                year: 'numeric',
                month: 'numeric',
                day: 'numeric'
            });

            axios.post('/get_available_slots', {
                date: date,
                service_id: this.selectedService.id,
                price_id: this.selectedService.price_id
            }).then((times) => {
                this.selectedService.timesObj = times.data
            })
        },
        resolver: ({values}) => {
            const errors = {};

            if (!values.firstname) {
                errors.firstname = [{message: 'Заполните имя'}];
            }
            if (!values.phone) {
                errors.phone = [{message: 'Заполните телефон'}];
            }

            return {
                values,
                errors
            };
        },
        onFormSubmit({valid}) {
            if (valid) {
                axios.post('/to_book', {
                    name: this.initialValues.firstname,
                    phone: this.initialValues.phone,
                    service_id: this.selectedService.id,
                    price_id: this.selectedService.price_id,
                    date: this.selectedService.date.toLocaleString('ru-RU', {
                        year: 'numeric',
                        month: 'numeric',
                        day: 'numeric'
                    }),
                    time: this.selectedService.time
                }).then(() => {
                    this.$swal('Бронь успешно отправлена');
                    setTimeout(() => {
                        window.location.href = '/'
                    }, 3000);
                }).catch(error => {
                    if (error.response.data.message)
                        this.$swal('Ошибка сервера');
                    else
                        this.$swal(error.response.data);
                });
                this.visible = false
            }
        }
    }
}
</script>
<template>
    <div style="display: flex">
        <div style="width: 40%">
            <ServiceCard
                v-for="service in services"
                :class="service.id === selectedService.id ? 'selected' : ''"
                :service="service"
                :selectedService="selectedService"
            />
        </div>
        <VDatePicker v-if="selectedService.id != null" v-model="selectedService.date"
                     @click="find_available_slots(selectedService.date)"/>
        <div>
            <Times v-if="selectedService.timesObj != null" :selectedService="selectedService"/>
            <Button @click="visible = true" v-if="selectedService.time != null" class="btn btn-success"
                    style="float: right; margin-top: 30px">Забронировать
            </Button>
        </div>
    </div>
    <Dialog v-model:visible="visible" modal header="Введите имя и номер телефона" :style="{ width: '25rem' }">
        <Form v-slot="$form"
              :initialValues
              :resolver
              @submit="onFormSubmit"
              class="flex flex-col gap-4 w-full sm:w-56">
            <div style="display: flex; flex-direction:column; justify-content: space-between">
                <div style="display: flex; flex-direction: column; justify-content: space-between">
                    <label for="firstname" class="font-semibold w-24">Имя</label>
                    <InputText v-model="initialValues.firstname" id="firstname" name="firstname" fluid/>
                    <Message v-if="$form.firstname?.invalid" severity="error" size="small" variant="simple">
                        {{ $form.firstname.error?.message }}
                    </Message>
                </div>
                <div
                    style="display: flex; flex-direction: column; justify-content: space-between; margin-top: 10px">
                    <label for="phone" class="font-semibold w-24">Телефон</label>
                    <InputMask v-model="initialValues.phone" id="phone" name="phone" mask="+7(999)999-99-99"
                               placeholder="+7(999)999-99-99" fluid/>
                    <Message v-if="$form.phone?.invalid" severity="error" size="small" variant="simple">
                        {{ $form.phone.error?.message }}
                    </Message>
                </div>
            </div>
            <div style="display: flex; justify-content: space-between; margin-top: 20px">
                <Button type="button" label="Отменить" severity="secondary" @click="visible = false"></Button>
                <Button type="submit" label="Сохранить"></Button>
            </div>
        </Form>
    </Dialog>
</template>
<style>
.selected {
    background: #acffac !important;
    color: #006400;
}
</style>
