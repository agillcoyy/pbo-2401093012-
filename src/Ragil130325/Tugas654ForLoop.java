/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Classes/Class.java to edit this template
 */
package Ragil130325;
import java.util.Scanner;
/**
 *
 * @author Muhamad Soleh
 */
public class Tugas654ForLoop {
public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);

        System.out.print("Masukkan angka: ");
        int base = scanner.nextInt();

        System.out.print("Masukkan nilai pangkat: ");
        int exponent = scanner.nextInt();

        int result = 1;
        for (int i = 0; i < exponent; i++) {
            result *= base;
        }

        System.out.println("Hasil: " + result);
        scanner.close();
    }
}
