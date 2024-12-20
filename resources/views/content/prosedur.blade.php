
@extends('index')
@section('content')


@push('style')

<style>
    .nav-pills .nav-link.active{
        background-color: red
    }
    .sticky-wrapper {
        position: -webkit-sticky;
        position: sticky;
        top: 0; /* or any offset */
        z-index: 1000; /* Make sure it stays on top */
    }
    
    .scrollable-container {
        max-height: 300px; /* Adjust based on your needs */
        overflow-y: auto;
    }
    
    .topics-detail-block-image {
        max-width: 100%; /* Responsive image */
    }
    .text-justify {
        text-align: justify !important;
    }
    .figure-caption {
        text-align: justify !important;
    }
</style>

@endpush

<style>
    #navbar-example3 .nav .nav-pills .flex-column .nav-link .active{
        background-color: red
    }
</style>

<section class="hero-section d-flex justify-content-center align-items-center" id="section_0">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-12 mx-auto">
                <h1 class="text-white text-center">Prosedur Pendaftaran Penerbit & ISBN</h1>
            </div>
        </div>
    </div>
</section>

<section class="explore-section section-padding">
    <div class="container" style="margin-top: -200px">
        <div class="row justify-content-center">
  
            <div class="col-lg-4 col-md-4 col-12">
                <div class="card bg-white shadow-lg" style=" position: -webkit-sticky; position: sticky; top: 20px; z-index: 1000;">
                    <div class="card-body">
                        <nav id="navbar-example3" class="h-100 flex-column align-items-stretch pe-4 border-end">
                            <nav class="nav nav-pills flex-column">
                                @foreach($grouped_data as $k => $group)
                                <a class="nav-link" href="#item-{{ $k }}">{{ $group['header'] }}</a>
                                @endforeach
                            </nav>
                        </nav>
                       
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-12">
                <div class="card bg-white shadow-lg">
                    <div class="card-body">
                        <div data-bs-spy="scroll" data-bs-target="#navbar-example3" data-bs-smooth-scroll="true" class="scrollspy-example-2" tabindex="0">
                            @foreach($grouped_data as $index => $group)
                                <div class="content-section" id="item-{{ $index }}">
                                    <center><h5 class="mb-3">{{ $group['header'] }}</h5></center>
                                    <div class="row d-flex ">
                                    <hr>
                                    @foreach($group['items'] as $item)
                                        @if($item['HREF'])
                                        <div class="card" style="width: 15rem;">
                                            <div style="height: 200px; overflow: hidden;">
                                                {{ $item['NOMOR']. ' ' }} - {{ $item['TITLE'] }}
                                                <hr>
                                                <img src="{{ config('app.url').'/prosedur/'.$item['HREF']}}" class="card-img-top" alt="..." style="height: 100%; width: 100%; object-fit: cover; object-position: center;" onclick="openModalImg('<?php echo htmlspecialchars($item['TITLE']); ?>', '{{ config('app.url').'/prosedur/'.$item['HREF'] }}', '<?php echo htmlspecialchars($item['NOMOR']); ?>', '<?php echo htmlspecialchars($item['DESCRIPTION']); ?>')">
                                            </div>
                                            <center><p style="font-size:11px">Image. {{  $item['NOMOR'] }} - {{ $item['IMAGE_DESC'] }}</p></center>
                                            <button type="button" class="btn btn-sm btn-primary" onclick="openModalImg('<?php echo htmlspecialchars($item['TITLE']); ?>', '{{ config('app.url').'/prosedur/'.$item['HREF'] }}', '<?php echo htmlspecialchars($item['NOMOR']); ?>', '<?php echo htmlspecialchars($item['DESCRIPTION']); ?>', '<?php echo htmlspecialchars($item['IMAGE_DESC']); ?>')">
                                                Lihat Detail
                                            </button>
                                            <hr>
                                        </div>
                                        @endif
                                    @endforeach 

                                    <!-- @foreach($group['items'] as $item)
                                        @if($item['HREF'])
                                        <div class="col-lg-6 col-md-6 col-12 mb-5">
                                            <center><p>{{ $item['NOMOR']. ' ' }} - {{ $item['TITLE'] }}</p></center>
                                            <img src="{{ config('app.url').'/prosedur/'.$item['HREF']}}" class="topics-detail-block-image img-fluid">
                                            <figcaption class="figure-caption text-center">Image. {{  $item['NOMOR'] }} - {{ $item['IMAGE_DESC'] }}</figcaption>
                                            @if(isset($item['DESCRIPTION']) && $item['DESCRIPTION'] != $item['IMAGE_DESC'])
                                            Deskripsi :
                                            <figcaption class="figure-caption text-justify">{!! $item['DESCRIPTION'] !!}</figcaption>
                                            @endif
                                        </div>
                                        @endif
                                    @endforeach  -->
                                    </div>
                                </div>
                            @endforeach
                           
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="sliderModal" tabindex="-1" aria-labelledby="sliderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sliderModalLabel">Slider Modal</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <!-- Slider (Carousel) -->
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <img src="{{ config('app.url').'/prosedur/'.$item['HREF']}}" class="d-block w-100" alt="Slide 1">
                    <center><p style="font-size:14px; margin-top:30px" id="sliderModalImgDesc"></p></center>
                </div>
            </div>
            <div style="padding:30px">
                Deskripsi : <div id="sliderModalDesc"></div>
            </div>
            <div class="modal-footer">
                
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navLinks = document.querySelectorAll('#navbar-example3 .nav-link');
        const sections = document.querySelectorAll('.content-section');

        // Function to remove active class from all nav links
        function removeActiveClass() {
            navLinks.forEach(link => link.classList.remove('active'));
        }

        // Function to add active class to the clicked nav link
        function setActiveLink(index) {
            removeActiveClass();
            navLinks[index].classList.add('active');
        }

        //buat scroll up
        const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const index = Array.from(sections).indexOf(entry.target);
                    setActiveLink(index);
                }
            });
        }, {
            threshold: 0.5 // Adjust this value to trigger earlier or later
        });
        // Observe each section
        sections.forEach(section => observer.observe(section));

        // Add click event listeners to each nav link (ketika di klik)
        navLinks.forEach((link, index) => {
            console.log(index, 'index foreach')
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Prevent default anchor behavior

                // Smooth scroll to the target section
                const targetId = link.getAttribute('href').substring(1); // Remove the '#'
                const targetSection = document.getElementById(targetId);

                if (targetSection) {
                    targetSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }

                // Update the active link
                setActiveLink(index);
            });
        });
    });

    function openModalImg(title, img, no, desc, imgdesc){
        var modalElement = document.getElementById('sliderModal');

        document.getElementById('sliderModalLabel').innerText = no + ' - ' +title;
        document.getElementById('sliderModalDesc').innerText = desc;
        document.getElementById('sliderModalImgDesc').innerText = 'Image. '+no+ ' - ' +imgdesc;

        // Create new carousel item with image and description
        var carouselItem = document.createElement('div');

        // Create image element
        var imgElement = document.createElement('img');
        imgElement.src = img; // Set image source dynamically
        imgElement.className = 'd-block w-100';
        imgElement.alt = title;

        // Initialize the modal with Bootstrap's Modal class
        var modal = new bootstrap.Modal(modalElement);

        modal.show();

    }
    


</script>