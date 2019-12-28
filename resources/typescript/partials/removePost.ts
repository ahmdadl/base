import Axios from 'axios'

export default function removePost (self, pid, redirect) {
    self.$root.$refs['delLoad' + pid].classList.remove('d-none')
        Axios.delete('/blog/posts/' + pid).then(res => {
            // console.log(res)
            if (res.data && res.data.done) {
                if (redirect) {
                    location.href = '/blog/posts'
                } else {
                    location.reload()
                }
            }
        })
        .catch(err => {/* console.log(err) */})
        .finally(() => {
            // @ts-ignore
            self.$root.$refs['delLoad' + pid].classList.add('d-none')
        })
}