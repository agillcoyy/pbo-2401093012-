/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil220425;

/**
 *
 * @author Muhamad Soleh
 */
public class Pegawai {
    private String nip;
    private String nama;
    private String golongan;
    private double gajiPokok;
    private double tunjangan;
    private double totalGaji;

    public Pegawai(String nip, String nama, String golongan) {
        this.nip = nip;
        this.nama = nama;
        this.golongan = golongan;
        hitungGaji();
    }

    private void hitungGaji() {
        switch (golongan) {
            case "1A":
                gajiPokok = 1000000;
                break;
            case "2A":
                gajiPokok = 2000000;
                break;
            case "3A":
                gajiPokok = 3000000;
                break;
            default:
                System.out.println("Golongan tidak valid");
                return;
        }

        tunjangan = gajiPokok * 0.05;
        totalGaji = gajiPokok + tunjangan;
    }

    public void tampilkanData() {
        System.out.println("NIP: " + nip);
        System.out.println("Nama: " + nama);
        System.out.println("Golongan: " + golongan);
        System.out.println("Gaji Pokok: Rp " + gajiPokok);
        System.out.println("Tunjangan: Rp " + tunjangan);
        System.out.println("Total Gaji: Rp " + totalGaji);
    }
}


