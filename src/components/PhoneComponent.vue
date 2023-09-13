<script setup>
import InputMask from 'primevue/inputmask'
import Button from 'primevue/button'
import Message from 'primevue/message'
import { ref } from 'vue'
import axios from 'axios'

const clientPhoneNumber = ref('')
const alertMessage = ref('')
const submitPhoneNumber = async () => {
  const formData = new FormData()
  formData.append('clientPhoneNumber', clientPhoneNumber.value)
  try {
    const response = await axios.post('../../sendClientPhone.php', formData)
    console.log(response)

    if (response.data.message === 'success') {
      alertMessage.value = {
        status: 'success',
        message: 'Номер телефона отправлен'
      }
    } else {
      alertMessage.value = {
        status: 'error',
        message: 'Ошибка в отправке'
      }
    }
  } catch (error) {
    console.error('Ошибка при отправке данных:', error)
  }
}
</script>

<template>
  <div class="phone">
    <div class="phone__container">
      <div class="phone__title">
        Введите ваш номер телефона
        <span>в формате СНГ</span>
      </div>
      <Message v-if="alertMessage" :severity="alertMessage.status">{{
        alertMessage.message
      }}</Message>
      <div class="phone__form">
        <label for="phone">Введите ваш номер телефона</label>
        <InputMask
          v-model="clientPhoneNumber"
          date="phone"
          mask="(099) 999-99-99"
          placeholder="(099) 332-22-12"
        />
        <div class="phone__form-btn">
          <input type="hidden" name="clientPhoneNumber" :value="clientPhoneNumber" />
          <Button
            type="submit"
            label="Submit"
            icon="pi pi-check"
            @click="submitPhoneNumber"
            :disabled="clientPhoneNumber.length < 1"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.phone {
  .phone__container {
    max-width: 500px;
    margin: auto;
    border-radius: 8px;
    border: 1px solid #e1e4eb;
    padding: 24px;
    min-height: 300px;
    height: fit-content;
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }
  &__title {
    font-size: 20px;
    font-weight: 500;
    line-height: 16px;
    color: #262729;
    text-align: center;
    & span {
      color: #666e7a;
    }
  }
  &__form {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin-top: 32px;
    & label {
      margin-bottom: 16px;
    }
    &-btn {
      margin-top: 16px;
    }
  }
}
</style>
