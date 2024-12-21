<x-app-layout>
    <section class="wsus__product mt_145 pb_100">
        <div class="container">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
            <br>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
