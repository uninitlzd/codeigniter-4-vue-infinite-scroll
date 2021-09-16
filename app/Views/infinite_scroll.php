<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infinite Scroll Demo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    
    <div id="infinite-scroll__wrapper">
      <div class="container">
        <div class="mx-auto w-50 py-5">
          <div class="card mb-3" v-for="content in contents" :key="content.id">
            <div class="card-header">{{ content.creator }}</div>
            <img :src="'https://via.placeholder.com/700?text='+content.id" class="img-fluid" alt="...">
            <div class="card-body">
              <p class="card-text">{{ content.description }}</p>

              <p><small>8 minutes ago</small></p>
            </div>
          </div>
          <div ref="observer" class="text-center" v-if="pager.currentPage < pager.pageCount">
            <div class="spinner-border spinner-border-sm" role="status">
              
            </div>
            Loading
          </div>
        </div>
      </div>
    </div>

    <script src="https://jp.vuejs.org/js/vue.js"></script>
    <script>
        var base_url = '<?= base_url() ?>'
        const vm = new Vue({
          el: '#infinite-scroll__wrapper',
          data() {
            return {
              name: 'Edo',
              contents: [],
              observer: null,
              pager: {
                currentPage: 0,
                pageCount: 1,
                next: null
              }
            }
          },
          async mounted() {
            this.observer = new IntersectionObserver(
              this.onElementObserved,
            );

            this.observer.observe(this.$refs.observer)
          },
          methods: {
            range: (start, end, length = end - start + 1) => Array.from({ length }, (_, i) => start + i),
            async fetchUsers() {
              try {
                let response

                if (this.pager.next != null) {
                  response = await fetch(this.pager.next)
                } else {
                  response = await fetch(`${base_url}/infinitescroll/fetchData`)
                }

                const parsedResponse = await response.json()
                const { contents, pager } = parsedResponse
                
                this.contents.push(...contents)
                this.pager = pager
        
                console.log(parsedResponse)
              } catch(err) {
                console.log(err) // state-of-the-art-error-handling
              }
            },
            async onElementObserved(entries) {
                entries.forEach(async entry => {
                    if (entry.intersectionRatio > 0) {
                      console.log('in the view');
                      await this.fetchUsers()
                    } else {
                      console.log('out of view');
                    }
                  });
            }
          },
        })
    </script>
</body>
</html>