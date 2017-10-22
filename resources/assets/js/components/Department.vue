<script>

    export default{
        props : ['department'],
        data() {
            return {
                editing: false,
                name: this.department.name,
                previousName: this.department.name,
                slug: this.department.slug,
                previousSlug: this.department.slug,
            };
        },
        methods: {
            update() {
                if (this.name === this.previousName ){
                    flash('No change made..!!!');
                }else {
                axios.patch('/departments/' + this.slug, {
                    name: this.name
                }).then(() => {
                    this.previousName = this.name;

                        let slug ;
                        // Change to lower case
                        let titleLower = this.name.toLowerCase();
                        // Letter "e"
//                        slug = titleLower.replace(/e|é|è|ẽ|ẻ|ẹ|ê|ế|ề|ễ|ể|ệ/gi, 'e');
//                        // Letter "a"
//                        slug = slug.replace(/a|á|à|ã|ả|ạ|ă|ắ|ằ|ẵ|ẳ|ặ|â|ấ|ầ|ẫ|ẩ|ậ/gi, 'a');
//                        // Letter "o"
//                        slug = slug.replace(/o|ó|ò|õ|ỏ|ọ|ô|ố|ồ|ỗ|ổ|ộ|ơ|ớ|ờ|ỡ|ở|ợ/gi, 'o');
//                        // Letter "u"
//                        slug = slug.replace(/u|ú|ù|ũ|ủ|ụ|ư|ứ|ừ|ữ|ử|ự/gi, 'u');
//                        // Letter "d"
//                        slug = slug.replace(/đ/gi, 'd');
                        // Trim the last whitespace
                        slug = titleLower.replace(/\s*$/g, '');
                        // Change whitespace to "-"
                        slug = slug.replace(/\s+/g, '-');
                    this.previousSlug = slug;
                    this.slug = this.previousSlug;

                    this.editing = false;

                    flash('Department Updated!');
                    location.reload()
                })
                    .catch(function () {
                        flash('Failed!! please try again');
                    });
                }

            },
            cancel() {
                this.name = this.previousName;
                this.slug = this.previousSlug;
                this.editing = false;
            }

        }
    }

</script>

