<script setup>
import Keycloak from 'keycloak-js';

// const keycloak = new Keycloak({
//     url: "https://auth.kioskapi.ru/",
//     realm: "master",
//     clientId: "tv"
// });
//
// const authenticated = await keycloak.init();
// if (authenticated) {
//     console.log('User is authenticated');
// } else {
//     console.log('User is not authenticated');
// }

const {botId} = defineProps({
    botId: {
        type: Number,
        default: 8085189188
    },
    failedAuth: Boolean
});

function openTelegramWindow() {
    const redirectUrl = encodeURIComponent(
        window.location.origin
        // `https://study.sr-platform.ru/login`
        // `${window.location.origin}/login`
    ); // URL для перенаправления
    const authUrl = `https://oauth.telegram.org/auth?bot_id=${botId}&origin=${redirectUrl}&embed=0&request_access=write`;

    // Открываем новое окно для авторизации
    const authWindow = window.open(
        authUrl,
        'Telegram Auth',
        'width=500,height=600'
    );

    // Обработка сообщений от окна авторизации
    const handleMessage = (event) => {
        // Проверяем, что сообщение пришло от Telegram
        if (event.origin !== 'https://oauth.telegram.org') return;

        // Получаем данные пользователя
        const userData = event.data;

        // Закрываем окно авторизации
        authWindow.close();
        // console.log(JSON.parse(userData).result);
        window.location.href = route('login.telegram')+'?'+new URLSearchParams(JSON.parse(userData).result).toString();
    };

    // Добавляем обработчик сообщений
    window.addEventListener('message', handleMessage);
}
</script>

<template>
    <div class="content">
        <div class="text" v-if="failedAuth">
            <h2 class="text-4xl">Доступ запрещён</h2>
            <p>Только избранные пользователи могут работать с данным сервисом</p>
        </div>
        <div class="text" v-else>
            <h2 class="text-4xl">Сначала авторизуйтесь</h2>
            <p>Только избранные пользователи могут работать с данным сервисом</p>
        </div>

        <a v-if="failedAuth" :href="`/`">
            <el-button class="telegram-login-button" style="width: 260px;">
                <template #default>
                <span class="telegram-text">
                Вернуться к показу видеороликов
            </span>
                </template>
            </el-button>
        </a>
        <div v-else class="flex flex-col gap-5">
            <el-button @click="openTelegramWindow" class="telegram-login-button">
                <template #default>
                    <el-avatar class="telegram-icon"/>
                    <span class="telegram-text">
                Войти через Телеграм
            </span>
                </template>
            </el-button>

            <a href="/login/keycloak">
                <el-button class="telegram-login-button">
                    <template #default>
                    <span class="telegram-text">
                Войти через SSO
            </span>
                    </template>
                </el-button>
            </a>
        </div>
    </div>
</template>

<style scoped>
.content {
    margin-top: 16%;
    max-width: 100%;
    max-height: 100%;
    display: flex;
    flex-direction: column;
    gap: 20px;
    justify-items: center;
    align-items: center;
    font-family: Arial, sans-serif; /* Шрифт */
    font-size: 16px;
    font-weight: bold;
}

.text {
    display: flex;
    flex-direction: column;
    gap: 10px;
    text-align: center;
}

.telegram-login-button {
    width: 240px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 20px 20px;
    background-color: #27a0dc; /* Цвет фона, как у Telegram */
    color: white; /* Цвет текста */
    border: none;
    border-radius: 20px; /* Скругление углов */
    cursor: pointer;
    transition: background-color 0.3s ease; /* Плавное изменение цвета */
}

.telegram-login-button:hover {
    background-color: #229ED9; /* Цвет фона при наведении */
}

.telegram-icon {
    display: inline-block;
    width: 24px;
    height: 24px;
    background-image: url('https://telegram.org/img/t_logo.svg'); /* Логотип Telegram */
    background-size: cover;
    margin-right: 10px; /* Отступ между иконкой и текстом */
}

.telegram-text {
    vertical-align: middle;
}
</style>


