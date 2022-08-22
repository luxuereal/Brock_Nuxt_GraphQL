<template>
    <div class="profile-avatar">
        <div class="avatar-img" @click="onChangeAvatar">
            <img v-if="avatarResource == '' || avatarResource == null" src="~assets/images/header/avatar.svg" />
            <img v-else :src="avatarResource"/>
        </div>
        <DefaultButton class="editBtn" padding="5px 12px" button-color-gamma="red" @event="onChangeAvatar"> Edit </DefaultButton>
        <input ref="avatarInput" class="avatar-input" type="file" @change="onAvatarChange" />
    </div>
</template>

<script>
export default {
    name: 'ProfileAvatar',
    props: {
        avatar: {
            type: String,
            default: ''
        }
    },
    data () {
        return {
            avatarResource: ''
        }
    },
    watch: {
      	avatar(newVal, oldVal) {
            this.avatarResource = newVal

            const avatarInput = this.$refs.avatarInput;
            avatarInput.value = ''
        }
    },
    methods: {
        onChangeAvatar() {
            const avatarInput = this.$refs.avatarInput;
            avatarInput.click();
        },
        onAvatarChange() {
            const avatarInput = this.$refs.avatarInput;

            if (avatarInput.files && avatarInput.files[0]) {
                const reader = new FileReader();

                const self = this;
                reader.onload = function (e) {
                    self.avatarResource = e.target.result;
                    self.$emit("changed", {avatarInput, avatarResource: e.target.result})
                };
                reader.readAsDataURL(avatarInput.files[0]);
            }
        },
    },
}
</script>

<style lang="scss" scoped>
.profile-avatar {
    .avatar-img {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        box-shadow: 2px 2px 6px black;
        cursor: pointer;

        img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }
    }
    .editBtn {
        padding: 5px 10px;
        transform: translate(10px, -40px);
    }
    .avatar-input {
        display: none;
    }
}
</style>
