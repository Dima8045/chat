<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card p-1">
                    <div class="card-header">Socket Chat</div>
                        <div class="form-group">
                            <textarea rows="10" class="form-control" readonly>{{ messages.join('\n')}}</textarea>
                        </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Enter message"  v-model="message" @keydown="actionUser">
                        <div class="input-group-append">
                            <button @click="sendMessage" class="btn btn-outline-secondary" type="button">Send</button>
                        </div>
                    </div>
                    <span v-if="isActive">{{ isActive.name }} typing...</span>
                </div>
            </div>
            <div class="col-md-4">
                <ul>
                    <li v-for="user in activeUsers">{{ user.name }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
      data() {
        return {
          messages: [],
          message: '',
          isActive: false,
          typingTime: false,
          activeUsers: [],
        }
      },
      props: [
        'room',
        'user'
      ],
      computed: {
        channel() {
          return window.Echo.join('room.' + this.room.id)
        }
      },
      mounted() {
        this.channel
          .here((users) => {
            this.activeUsers = users
          })
          .joining((user) => {
            this.activeUsers.push(user)
          })
          .leaving((user) => {
            this.activeUsers.splice(this.activeUsers.indexOf(user), 1)
          })
          .listen('Message', ({data}) => {
            this.messages.push(data.message)
            this.isActive = false
          })
          .listenForWhisper('typing', (e) => {
            this.isActive = e
            if (this.typingTime ) clearTimeout(this.typingTime)
            this.typingTime = setTimeout(() => {
              this.isActive = false
            }, 2000)
          })
      },
      methods: {
        sendMessage() {
            axios.post('/send-message', {message: this.message, roomId: this.room.id})
        },
        actionUser() {
          this.channel
            .whisper('typing', {
              name: this.user.name
            })
        }
      }
    }
</script>
