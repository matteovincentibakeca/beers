<template>
    <div class="p-4 bg-slate-200 min-h-screen">
        <div class="container mx-auto py-4 flex gap-4">
            <div class="w-2/3">
                <div class="space-y-2">
                    <template v-for="item in data.data" :key="item.id">
                        <div @click="select(item)" class="border shadow p-4 bg-white text-slate-800 rounded cursor-pointer">
                            <h1>{{item.name}}</h1>
                            <p class="text-sm text-slate-600 mt-2">{{item.description}}</p>
                            <button class="mt-2.5 block text-sky-600 text-sm">Leggi tutto</button>
                        </div>
                    </template>
                </div>
                <div class="mt-4 flex gap-2 items-center">
                    <button class="px-4 py-1.5 rounded bg-sky-500 text-white" v-show="data?.links?.prev" @click="prev">prev</button>
                    <button class="px-4 py-1.5 rounded bg-sky-500 text-white" v-show="data?.links?.next" @click="next">next</button>
                </div>
            </div>
            <div class="w-1/3">
                <div v-if="selectedItem" class="border shadow p-4 bg-white text-slate-800 rounded sticky top-4">
                    <div class="aspect-square w-full p-6 border rounded flex items-center justify-center mb-4">
                        <img :src="selectedItem.thumb" :alt="selectedItem.name" class="h-full block">
                    </div>
                    <h1>{{selectedItem.name}}</h1>
                    <p class="text-sm text-slate-600 mt-2">{{selectedItem.description}}</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            selectedItem: null,
            data: [],
            error: null,
        }
    },
    created() {
        this.$watch(
            () => this.$route.params,
            () => {
                this.fetchData(this.$route.params?.page)
            },
            { immediate: true }
        )
    },
    methods: {
        select: function (item) {
            this.selectedItem = item
        },
        fetchData: function (page=1) {
            axios.get(`/api/beers?page=${page || 1}`, {
                headers: { Authorization: `Bearer ${window.localStorage.getItem('token')}` }
            }).then(({ data }) => {
                this.data = data.data
            })
        },
        next: function () {
            const next = (Number(this.$route.params?.page) || 1) + 1
            this.$router.push({ path: `/${next}` })
        },
        prev: function () {
            const prev = ((Number(this.$route.params?.page)) || 1) - 1
            this.$router.push({ path: `/${prev}`})
        }
    }
}
</script>
