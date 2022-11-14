package main

import (
	"github.com/stretchr/testify/require"
	"testing"

	"github.com/kulti/titlecase"
)

// Задание
// 1. Дописать существующие тесты.
// 2. Придумать один новый тест.
//
// Дополнительное задание: использовать табличные тесты и testify.require
//
// Документация по тестируемой функции:
// Делает слова в строке из первого аргумента с большой буквы, кроме слов из строки из второго аргумента
// Первое слово всегда с большой буквы
//
// TitleCase(str, minor) returns a str string with all words capitalized except minor words.
// The first word is always capitalized.
//
// E.g.
// TitleCase("the quick fox in the bag", "") = "The Quick Fox In The Bag"
// TitleCase("the quick fox in the bag", "in the") = "The Quick Fox in the Bag"

func TestEmpty(t *testing.T) {
	const str, minor, want = "", "", ""
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}
func TestWithoutMinor(t *testing.T) {
	// передайте пустую строку в качестве второго агрумента
	//t.Error("not implemented")
	const str, minor, want = "The Quick Fox in the Bag", "", "The Quick Fox in the Bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}

func TestWithMinorInFirst(t *testing.T) {
	// передайте первое слово исходной строки в качестве второго аргумента
	//t.Error("not implemented")
	const str, minor, want = "the quick fox in the bag", "the", "the quick fox in the bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
}
func TestAllMinor(t *testing.T) {
	// передайте всю строку в качестве второго аргумента
	//t.Error("not implemented")
	const str, minor, want = "the quick fox in the bag", "the quick fox in the bag", "the quick fox in the bag"
	got := titlecase.TitleCase(str, minor)
	if got != want {
		t.Errorf("TitleCase(%v, %v) = %v; want %v", str, minor, got, want)
	}
