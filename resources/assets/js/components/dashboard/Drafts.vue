<template>
    <div>
        <h2>
            Drafts
        </h2>

        <div class="columns">
            <div v-for="draft in drafts" class="column">
                <div class="box" v-on:click="goToRoom(draft.id)">
                    <h3 class="title is-5">{{ draft.name }}</h3>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                drafts: []
            };
        },
        mounted() {
            this.prepareComponent()

            console.log('Component ready.')
        },

        methods: {
            prepareComponent() {
                this.getDrafts();
            },

            getDrafts(){
                this.$http.get('/api/drafts')
                    .then(response => {
                        this.drafts = response.body.data.attributes.games;
                        console.log(this.drafts)
                    });
            },
            goToRoom(id){
                window.location = "/draft/"+id;
            }

        }
    }
</script>


