<?php

require 'connection.php';

$room = $_GET['room'];

?>

<?php include('header.php'); ?>

<div class="flex justify-center mt-60">
    <div class="block p-6 rounded-lg shadow-lg bg-white max-w-sm">
        <h3 class="font-bold mb-4 text-center text-xl">
            Room <?= $room; ?>
        </h3>
        <form>
            <div class="form-group mb-2">
                <!--                <label class="form-label inline-block text-gray-700">Name</label>-->
                <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInputEmail1"
                       type="text" placeholder="Name">
            </div>
            <div class="form-group mb-2">
                <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInputEmail1"
                       type="email" placeholder="Email">
            </div>
            <div class="form-group mb-2">
                <input class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="exampleInputEmail1"
                       type="text" placeholder="Phone">
            </div>
            <div class="text-center">
                <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                    Reserve
                </button>
            </div>
        </form>
    </div>
</div>

<?php include('footer.php'); ?>
